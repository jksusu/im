<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/6/22
 * Time: 下午1:21
 */

namespace EasySwoole\Component\Pool;


use EasySwoole\Component\Pool\Exception\PoolObjectNumError;
use EasySwoole\Utility\Random;
use Swoole\Coroutine\Channel;

abstract class AbstractPool
{
    use TraitInvoker;

    private $createdNum = 0;
    private $inuse = 0;
    private $poolChannel;
    private $objHash = [];
    private $conf;

    /*
     * 如果成功创建了,请返回对应的obj
     */
    abstract protected function createObject();

    public function __construct(PoolConf $conf)
    {
        if ($conf->getMinObjectNum() >= $conf->getMaxObjectNum()) {
            $class = static::class;
            throw new PoolObjectNumError("pool max num is small than min num for {$class} error");
        }
        $this->conf = $conf;
        $this->poolChannel = new Channel($conf->getMaxObjectNum() + 1);
        if ($conf->getIntervalCheckTime() > 0) {
            swoole_timer_tick($conf->getIntervalCheckTime(), [$this, 'intervalCheck']);
        }
    }

    /*
     * 回收一个对象
     */
    public function recycleObj($obj): bool
    {
        if (is_object($obj)) {
            if ($obj instanceof PoolObjectInterface) {
                $obj->objectRestore();
            }
            $ret = $this->putObject($obj);
            if ($ret) {
                $this->inuse--;
            }
            return true;
        }
        return false;
    }

    public function getObj(float $timeout = null, int $beforeUseTryTimes = 3)
    {
        if ($timeout === null) {
            $timeout = $this->conf->getGetObjectTimeout();
        }
        if ($beforeUseTryTimes <= 0) {
            return null;
        }
        //懒惰创建模式
        $obj = null;
        if ($this->poolChannel->isEmpty()) {
            //如果还没有达到最大连接数，则尝试进行创建
            if ($this->createdNum < $this->conf->getMaxObjectNum()) {
                $this->createdNum++;
                /*
                 * 创建对象的时候，请加try,尽量不要抛出异常
                 */
                $obj = $this->createObject();
                if (is_object($obj)) {
                    //标记手动标记一个id   spl_hash 存在坑
                    $hash = Random::character(16);
                    $obj->__objectHash = $hash;
                    //标记为false,才可以允许put回去队列
                    $this->objHash[$hash] = false;
                    if (!$this->putObject($obj)) {
                        $this->createdNum--;
                        unset($this->objHash[$hash]);
                    }
                }else{
                    $this->createdNum--;
                }
                //同样进入调度等待,理论上此处可以马上pop出来
                $obj = $this->poolChannel->pop($timeout);
            } else {
                $obj = $this->poolChannel->pop($timeout);
            }
        } else {
            $obj = $this->poolChannel->pop($timeout);
        }
        //对对象进行标记处理
        if (is_object($obj)) {
            //上一步已经put object了，put object中设置了__objectHash
            $key = $obj->__objectHash;
            //标记这个对象已经出队列了
            $this->objHash[$key] = false;
            if ($obj instanceof PoolObjectInterface) {
                //请加try,尽量不要抛出异常
                $status = $obj->beforeUse();
                if ($status === false) {
                    $this->unsetObj($obj);
                    //重新进入对象获取
                    return $this->getObj($timeout, $beforeUseTryTimes - 1);
                }
            }
            $this->inuse++;
            return $obj;
        } else {
            return null;
        }
    }

    /*
     * 彻底释放一个对象
     */
    public function unsetObj($obj): bool
    {
        if (is_object($obj)) {
            if (!isset($obj->__objectHash)) {
                return false;
            }
            $key = $obj->__objectHash;
            if (isset($this->objHash[$key])) {
                unset($this->objHash[$key]);
                $this->createdNum--;
                if ($obj instanceof PoolObjectInterface) {
                    $obj->objectRestore();
                    $obj->gc();
                }
                unset($obj);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /*
     * 超过$idleTime未出队使用的，将会被回收。
     */
    public function gcObject(int $idleTime)
    {
        $list = [];
        while (true) {
            if (!$this->poolChannel->isEmpty()) {
                $obj = $this->poolChannel->pop(0.001);
                if (is_object($obj)) {
                    if (time() - $obj->last_recycle_time > $idleTime) {
                        $this->unsetObj($obj);
                    } else {
                        array_push($list, $obj);
                    }
                }
            } else {
                break;
            }
        }
        foreach ($list as $item) {
            $this->putObject($item);
        }
    }

    protected function intervalCheck()
    {
        $this->gcObject($this->conf->getMaxIdleTime());
        $this->keepMin();
    }

    protected function getPoolConfig(): PoolConf
    {
        return $this->conf;
    }

    public function keepMin(?int $num = null): int
    {
        if ($num == null) {
            $num = $this->conf->getMinObjectNum();
        }
        if ($this->createdNum >= $num) {
            return $this->createdNum;
        } else {
            $num = $num - $this->createdNum;
        }

        for ($i = 0; $i < $num; $i++) {
            $this->createdNum++;
            $obj = $this->createObject();
            $hash = Random::character(16);
            if (is_object($obj)) {
                //标记手动标记一个id   spl_hash 存在坑
                $obj->__objectHash = $hash;
                //标记为false,才可以允许put回去队列
                $this->objHash[$hash] = false;
                if (!$this->putObject($obj)) {
                    $this->createdNum--;
                }
            }else{
                $this->createdNum--;
            }

        }
        return $this->createdNum;
    }

    /*
     * 用以解决冷启动问题,其实是是keepMin别名
    */
    public function preLoad(?int $num = null): int
    {
        return $this->keepMin($num);
    }

    /*
     * 把一个对象归还到队列中
     */
    protected function putObject($object): bool
    {
        if (is_object($object)) {
            if (!isset($object->__objectHash)) {
                return false;
            }
            $hash = $object->__objectHash;
            //不在的时候说明为其他pool对象，不允许归还，若为true,说明已经归还，禁止重复
            if (isset($this->objHash[$hash]) && ($this->objHash[$hash] === false)) {
                $object->last_recycle_time = time();
                $this->objHash[$hash] = true;
                $this->poolChannel->push($object);
                return true;
            }
        }
        return false;
    }

    public function getConfig():PoolConf
    {
        return $this->conf;
    }

    public function status()
    {
        return [
            'created' => $this->createdNum,
            'inuse' => $this->inuse,
            'max' => $this->getPoolConfig()->getMaxObjectNum(),
            'min' => $this->getPoolConfig()->getMinObjectNum()
        ];
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018-12-27
 * Time: 12:13
 */

namespace EasySwoole\Actor;


use EasySwoole\Spl\SplBean;
use Swoole\Coroutine\Channel;

abstract class AbstractActor extends SplBean
{
    protected $hasDoExit = false;
    protected $actorId;
    protected $arg;
    private $channel;
    private $tickList = [];
    private $replyChannel;
    protected $block = false;

    function __construct(array $data = null, bool $autoCreateProperty = false)
    {
        parent::__construct($data, $autoCreateProperty);
    }

    function setBlock(bool $bool)
    {
        $this->block = $bool;
        return $this;
    }

    abstract static function configure(ActorConfig $actorConfig);

    abstract function onStart($arg);

    abstract function onMessage($msg);

    abstract function onExit($arg);

    function actorId()
    {
        return $this->actorId;
    }

    function setActorId($id)
    {
        $this->actorId = $id;
        return $this;
    }

    /*
     * 请用该方法来添加定时器，方便退出的时候自动清理定时器
     */
    function tick($time, callable $callback)
    {
        $id = swoole_timer_tick($time, function () use ($callback) {
            try {
                call_user_func($callback);
            } catch (\Throwable $throwable) {
                $this->onException($throwable);
            }
        });
        $this->tickList[$id] = $id;
        return $id;
    }

    /*
     * 请用该方法来添加定时器，方便退出的时候自动清理定时器
     */
    function after($time, callable $callback)
    {
        $id = swoole_timer_after($time, function () use ($callback) {
            try {
                call_user_func($callback);
            } catch (\Throwable $throwable) {
                $this->onException($throwable);
            }
        });
        return $id;
    }

    function deleteTick(int $timerId)
    {
        unset($this->tickList[$timerId]);
        return swoole_timer_clear($timerId);
    }

    function getArg()
    {
        return $this->arg;
    }

    function setArg($arg)
    {
        $this->arg = $arg;
        return $this;
    }

    function getChannel(): ?Channel
    {
        return $this->channel;
    }

    function __startUp(Channel $replyChannel)
    {
        $this->channel = new Channel(64);
        $this->replyChannel = $replyChannel;
        if ($this->block) {
            go(function () use ($replyChannel) {
                try {
                    $this->onStart($this->arg);
                } catch (\Throwable $throwable) {
                    $this->onException($throwable);
                }
                $this->listen();
            });
        } else {
            go(function () {
                try {
                    $this->onStart($this->arg);
                } catch (\Throwable $throwable) {
                    $this->onException($throwable);
                }
            });
            $this->listen();
        }
    }

    /*
     * 一个actor可以自杀
     */
    protected function exit($arg = null)
    {
        $this->channel->push([
            'msg' => 'exit',
            'reply' => false,
            'arg' => $arg
        ]);
    }

    private function exitHandler($arg)
    {
        $reply = null;
        try {
            //清理定时器
            foreach ($this->tickList as $tickId) {
                swoole_timer_clear($tickId);
            }
            $this->hasDoExit = true;
            $this->channel->close();
            $reply = $this->onExit($arg);
            if ($reply === null) {
                $reply = true;
            }
        } catch (\Throwable $throwable) {
            $reply = $this->onException($throwable);
        }
        return $reply;
    }

    abstract protected function onException(\Throwable $throwable);

    public static function invoke(): ?ActorClient
    {
        return Actor::getInstance()->client(static::class);
    }

    public function wakeUp(Channel $replyChannel)
    {
        $this->replyChannel = $replyChannel;
        $this->channel = new Channel(64);
        $this->listen();
    }

    private function listen()
    {
        go(function () {
            while (!$this->hasDoExit) {
                $array = $this->channel->pop();
                if (is_array($array)) {
                    if($this->block){
                        $this->handlerMsg($array);
                    }else{
                        go(function ()use($array){
                            $this->handlerMsg($array);
                        });
                    }
                }
            }
        });
    }

    private function handlerMsg(array $array)
    {
        $msg = $array['msg'];
        if ($msg == 'exit') {
            $reply = $this->exitHandler($array['arg']);
        } else {
            try {
                $reply = $this->onMessage($msg);
            } catch (\Throwable $throwable) {
                $reply = $this->onException($throwable);
            }
        }
        if ($array['reply']) {
            $conn = $array['connection'];
            $string = Protocol::pack(serialize($reply));
            for ($written = 0; $written < strlen($string); $written += $fwrite) {
                $fwrite = $conn->send(substr($string, $written));
                if ($fwrite === false) {
                    break;
                }
            }
            $this->replyChannel->push($conn);
        }
    }
}

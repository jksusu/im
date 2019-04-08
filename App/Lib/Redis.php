<?php
/**
 * Created by PhpStorm.
 * User: jksusu
 * Date: 2019/3/2
 * Time: 14:03
 */

namespace App\Lib;


use EasySwoole\Component\Singleton;
use EasySwoole\EasySwoole\Config;

class Redis
{
    use Singleton;

    protected $redis;

    function __construct()
    {
        $this->redis = new \Redis();
    }

    function getConnect(): \Redis
    {
        return $this->redis;
    }

    function connect(): Redis
    {
        $conf = Config::getInstance()->getConf('REDIS');
        $this->redis->connect($conf['HOST'], $conf['PORT']);
        $this->redis->setOption(\Redis::OPT_SERIALIZER, \Redis::SERIALIZER_PHP);
        $this->redis->setOption(\Redis::OPT_READ_TIMEOUT, -1);
        if (!empty($conf['AUTH'])) {
            $this->redis->auth($conf['AUTH']);
        }
        return $this;
    }

    /**
     * 设置
     * @param $key
     * @param $val
     * @param int $timeout
     */
    function set($key, $val, $timeout = 0)
    {
        $this->redis->set($key, $val, $timeout);
    }

    /**
     * 获取
     * @param $key
     * @return bool|string
     */
    function get($key)
    {
       return  $this->redis->get($key);
    }

    /**
     * 消息订阅发布端
     * @param $keyword
     * @param $argument
     */
    function publish($keyword, $argument)
    {
        $this->redis->publish($keyword, $argument);
    }

    /**
     * 消息订阅订阅端
     * @param $channels
     * @param $callback
     */
    function subscribe($channels, $callback)
    {
       return $this->redis->subscribe($channels, $callback);
    }
}
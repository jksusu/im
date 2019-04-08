<?php

namespace App\Lib\Pool;

use EasySwoole\Component\Pool\AbstractPool;
use EasySwoole\EasySwoole\Config;

class RedisPool extends AbstractPool
{
    protected function createObject()
    {
        $redis = new RedisObject();
        $conf = Config::getInstance()->getConf("REDIS");
        $redis->connect($conf['HOST'], $conf['PORT']);
        $redis->setOption(\Redis::OPT_SERIALIZER, \Redis::SERIALIZER_PHP);
        return $redis;
    }
}
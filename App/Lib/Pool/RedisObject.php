<?php

namespace App\Lib\Pool;

use EasySwoole\Component\Pool\PoolObjectInterface;

class RedisObject extends \Redis implements PoolObjectInterface
{
    function gc()
    {
        $this->close();
    }

    function objectRestore()
    {
    }

    function beforeUse(): bool
    {
        return true;
    }
}
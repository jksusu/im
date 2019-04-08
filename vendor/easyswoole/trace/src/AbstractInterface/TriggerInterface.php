<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/8/14
 * Time: 下午12:39
 */

namespace EasySwoole\Trace\AbstractInterface;


use EasySwoole\Trace\Bean\Location;

interface TriggerInterface
{
    public function error($msg,int $errorCode = E_USER_ERROR,Location $location = null);
    public function throwable(\Throwable $throwable);
}
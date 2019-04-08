<?php
/**
 * Created by PhpStorm.
 * User: jksusu
 * Date: 2019/3/21
 * Time: 15:20
 */

namespace App\Process;

use EasySwoole\Component\Process\AbstractProcess;
use Swoole\Process;
use App\Lib\Redis;

class Subscribe extends AbstractProcess
{
    public function run($arg)
    {
        $redis = Redis::getInstance()->connect();
        $redis->subscribe(['addFriends'], function ($obj,$name,$msg) {
            $message = new \App\WebSocket\Controller\Message();
            $data = json_decode($msg,true);
            var_dump($data);
            $message->addPush(1, $data);
        });
    }

    public function onShutDown()
    {
        // TODO: Implement onShutDown() method.
    }

    public function onReceive(string $str, ...$args)
    {
        // TODO: Implement onReceive() method.
    }
}
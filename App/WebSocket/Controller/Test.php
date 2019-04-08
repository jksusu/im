<?php
/**
 * Created by PhpStorm.
 * User: jksusu
 * Date: 2019/2/26
 * Time: 20:41
 */

namespace App\WebSocket\Controller;

use EasySwoole\EasySwoole\ServerManager;
use EasySwoole\EasySwoole\Swoole\Task\TaskManager;
use EasySwoole\Socket\AbstractInterface\Controller;

class Test extends Controller
{
    function index()
    {
    }

    function hello()
    {
        $this->response()->setMessage('call hello with arg:' . json_encode($this->caller()->getArgs()));
    }

    public function who()
    {
        $this->response()->setMessage('你的 fd 是 ' . $this->caller()->getClient()->getFd());
    }

    function delay()
    {
        $this->response()->setMessage('this is delay action');
        $client = $this->caller()->getClient();

        // 异步推送, 这里直接 use fd也是可以的
        // TaskManager::async 回调参数中的代码是在 task 进程中执行的 默认不含连接池 需要注意可能出现 getPool null的情况
        TaskManager::async(function () use ($client) {
            $server = ServerManager::getInstance()->getSwooleServer();
            $i = 0;
            while ($i < 5) {
                sleep(1);
                $server->push($client->getFd(), 'push in http at ' . time());
                $i++;
            }
        });
    }

    /*
     * 收到消息事件
     */
    public function chatMessage()
    {
        $data = $this->caller()->getArgs();
        echo 'hahahhahah';
        var_dump($data) . PHP_EOL;
    }
}
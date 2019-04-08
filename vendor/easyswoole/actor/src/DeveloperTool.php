<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2019-01-05
 * Time: 02:14
 */

namespace EasySwoole\Actor;


use Swoole\Coroutine\Channel;

class DeveloperTool
{
    private $replyChannel;
    private $actor;

    private $onReply;

    function __construct(string $actorClass,$actorId,$actorArg = null)
    {
        $this->replyChannel = new Channel(32);
        $this->actor = new $actorClass($actorId,$this->replyChannel,$actorArg);
    }

    function push($msg)
    {
        $reply = fopen('php://memory','r+');
        $this->actor->getChannel()->push([
            'msg'=>$msg,
            'connection'=>$reply,
            'reply'=>true
        ]);
    }

    function onReply(callable $call):DeveloperTool
    {
        $this->onReply = $call;
        return $this;
    }

    function run()
    {
        go(function (){
            $this->actor->__run();
        });
        go(function (){
            while (1){
                $replyConn = $this->replyChannel->pop();
                fseek($replyConn,0);
                $data = stream_get_contents($replyConn);
                if(!empty($data)){
                    $data = Protocol::unpack($data);
                    $data = unserialize($data);
                    if(is_callable($this->onReply)){
                        call_user_func($this->onReply,$data);
                    }
                }
                fclose($replyConn);
            }
        });
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018-12-27
 * Time: 13:57
 */

namespace EasySwoole\Actor;


use EasySwoole\Actor\Exception\Exception;
use Swoole\Coroutine\Channel;

class ActorClient
{
    private $actorConfig;
    private $tempDir;
    private $serverName;

    function __construct(ActorConfig $config,string $tempDir,string $serverName)
    {
        $this->actorConfig = $config;
        $this->tempDir = $tempDir;
        $this->serverName = $serverName;
    }

    /*
     * 创建默认一直等待
     */
    function create($arg = null,$timeout = -1)
    {
        $command = new Command();
        $command->setCommand('create');
        $command->setArg($arg);
        //快速获得全部进程的创建结果
        $info = $this->status();
        //先计算总数 并找出最小key
        $minKey = null;
        $minNum = null;
        $all = 0;
        foreach ($info['createNum'] as $index => $createdNum)
        {
            $all = $all + $createdNum;
            if($createdNum <= $minNum){
                $minKey = $index;
                $minNum = $createdNum;
            }else if($minNum === null){
                $minNum = $createdNum;
                $minKey = $index;
            }
        }
        if($all >= $this->actorConfig->getMaxActorNum()){
            return -1;
        }else{
            return $this->sendAndRecv($command,$timeout,$this->generateSocketByProcessIndex($minKey));
        }
    }

    function exit(string $actorId,$arg = null,$timeout = 3.0)
    {
        $processIndex = self::actorIdToProcessIndex($actorId);
        $command = new Command();
        $command->setCommand('exit');
        $command->setArg([
            'actorId'=>$actorId,
            'msg'=>$arg
        ]);
        return $this->sendAndRecv($command,$timeout,$this->generateSocketByProcessIndex($processIndex));
    }

    function exitAll($arg = null,$timeout = 3.0)
    {
        $command = new Command();
        $command->setCommand('exitAll');
        $command->setArg($arg);
        return $this->broadcast($command,$timeout);
    }

    function push(string $actorId, $msg = null, $timeout = 3.0)
    {
        $processIndex = self::actorIdToProcessIndex($actorId);
        $command = new Command();
        $command->setCommand('sendTo');
        $command->setArg([
            'actorId'=>$actorId,
            'msg'=>$msg
        ]);
        return $this->sendAndRecv($command,$timeout,$this->generateSocketByProcessIndex($processIndex));
    }

    /*
     * ['actorId1'=>$data,'actorId2'=>$data]
     */
    function pushMulti(array $data,$timeout = 3.0)
    {
        $allNum = count($data);
        $channel = new Channel($allNum+1);
        foreach ($data as $actorId => $msg){
            go(function ()use($channel,$actorId,$msg,$timeout){
                $channel->push([
                    $actorId=>$this->push($actorId,$msg,$timeout)
                ]);
            });
        }
        $ret = [];
        $start = microtime(true);
        while (1){
            if(microtime(true) - $start > $timeout){
                break;
            }
            $temp = $channel->pop($timeout);
            if(is_array($temp)){
                $ret += $temp;
                if(count($ret) == $allNum){
                    break;
                }
            }
        }
        return $ret;
    }

    /*
     * ['actorId1'=>$data,'actorId2'=>$data]
     */
    function fastPushMulti(array $data,$timeout = 3.0)
    {
        $final = [];
        foreach ($data as $actorId => $item){
            $final[self::actorIdToProcessIndex($actorId)][$actorId] = $item;
        }
        foreach ($final as $processIndex => $data){
            $command = new Command();
            $command->setCommand('fastPushMulti');
            $command->setArg($final[$processIndex]);
            go(function ()use($command,$timeout,$processIndex){
                $this->sendAndRecv($command,$timeout,$this->generateSocketByProcessIndex($processIndex));
            });
        }
    }

    function broadcastPush($msg, $timeout = 3.0)
    {
        $command = new Command();
        $command->setCommand('broadcast');
        $command->setArg($msg);
        return $this->broadcast($command,$timeout);
    }

    function status($timeout = 3.0)
    {
        $command = new Command();
        $command->setCommand('createdNum');
        return [
            'name'=>$this->actorConfig->getActorName(),
            'maxNum'=>$this->actorConfig->getMaxActorNum(),
            'processNum'=>$this->actorConfig->getActorProcessNum(),
            'createNum'=> $this->broadcast($command,$timeout)
        ];
    }

    function exist(string $actorId,$timeout = 3.0)
    {
        $command = new Command();
        $command->setCommand('exist');
        $command->setArg($actorId);
        return $this->sendAndRecv($command,$timeout,$this->generateSocketByActorId($actorId));
    }

    private function broadcast(Command $command,$timeout = 3.0)
    {
        $info = [];
        $channel = new Channel($this->actorConfig->getActorProcessNum()+1);
        for ($i = 1;$i <= $this->actorConfig->getActorProcessNum();$i++){
            go(function ()use($command,$channel,$i,$timeout){
                $ret = $this->sendAndRecv($command,$timeout,$this->generateSocketByProcessIndex($i));
                $channel->push([
                   $i => $ret
                ]);
            });
        }
        $start = microtime(true);
        while (1){
            if(microtime(true) - $start > $timeout){
                break;
            }
            $temp = $channel->pop($timeout);
            if(is_array($temp)){
                $info += $temp;
                if(count($info) == $this->actorConfig->getActorProcessNum()){
                    break;
                }
            }
        }
        return $info;
    }

    private function generateSocketByProcessIndex($processIndex):string
    {
        return $this->tempDir."/{$this->serverName}.ActorProcess.{$this->actorConfig->getActorName()}.{$processIndex}.sock";
    }

    private function generateSocketByActorId(string $actorId):string
    {
        return $this->generateSocketByProcessIndex(self::actorIdToProcessIndex($actorId));
    }

    private function sendAndRecv(Command $command,$timeout,$socketFile)
    {
        $client = new UnixClient($socketFile);
        $ret = $client->send(serialize($command));
        if($ret === false){
            throw new Exception('unix send data error in error code:'.$client->client()->errCode);
        }
        $ret = $client->recv($timeout);
        if(!empty($ret)){
            return unserialize($ret);
        }
        return null;
    }

    public static function actorIdToProcessIndex(string $actorId):int
    {
        $processIndex = ltrim(substr($actorId,0,3),'0');
        if(empty($processIndex)){
            return 0;
        }else{
            return $processIndex;
        }
    }
}
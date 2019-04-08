<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018-12-27
 * Time: 12:10
 */

namespace EasySwoole\Actor;


use EasySwoole\Actor\Exception\InvalidActor;
use EasySwoole\Actor\Exception\RuntimeError;
use EasySwoole\Component\Singleton;

class Actor
{
    use Singleton;

    protected $actorList = [];
    private $tempDir;
    private $serverName = 'EasySwoole';
    private $run = false;

    function __construct()
    {
        $this->tempDir = getcwd();
    }

    public function setServerName(string $serverName): Actor
    {
        $this->modifyCheck();
        $this->serverName = $serverName;
        return $this;
    }

    function setTempDir(string $dir):Actor
    {
        $this->modifyCheck();
        $this->tempDir = $dir;
        return $this;
    }

    function register(string $actorClass):ActorConfig
    {
        $ref = new \ReflectionClass($actorClass);
        if($ref->isSubclassOf(AbstractActor::class)){
            $config = new ActorConfig();
            $actorClass::configure($config);
            if(empty($config->getActorName())){
                throw new InvalidActor("actor name for class:{$actorClass} is required");
            }
            if(in_array($config->getActorName(),$this->actorList)){
                throw new InvalidActor("actor name for class:{$actorClass} is duplicate");
            }
            $this->actorList[$actorClass] = $config;
            return $config;
        }else{
            throw new InvalidActor("actor class:{$actorClass} invalid");
        }
    }

    function client(string $actorClass):?ActorClient
    {
        if(isset($this->actorList[$actorClass])){
            return new ActorClient($this->actorList[$actorClass],$this->tempDir,$this->serverName);
        }else{
            return null;
        }
    }

    function attachToServer(\swoole_server $server)
    {
        $list = $this->initProcess();
        foreach ($list as $process){
            /** @var $proces ActorProcess */
            $server->addProcess($process->getProcess());
        }
    }

    function initProcess():array
    {
        $this->run = true;
        $processList = [];
        foreach ($this->actorList as $actorClass => $config){
            /** @var $config ActorConfig */
            $subName = "{$this->serverName}.ActorProcess.{$config->getActorName()}";
            for($i = 1;$i <= $config->getActorProcessNum();$i++){
                $processConfig = new ProcessConfig();
                $processConfig->setActorClass($actorClass);
                $processConfig->setTempDir($this->tempDir);
                $finaleName = "{$subName}.{$i}";
                $processConfig->setIndex($i);
                $processConfig->setProcessName($finaleName);
                $processConfig->setBacklog($config->getBacklog());
                $processConfig->setOnStart($config->getOnStart());
                $processConfig->setOnShutdown($config->getOnShutdown());
                $processConfig->setBlock($config->isBlock());
                $processConfig->setOnTick($config->getOnTick());
                $processConfig->setTick($config->getTick());
                $processConfig->setProcessOnException($config->getProcessOnException());
                $process = new ActorProcess($finaleName,$processConfig);
                $processList[] = $process;
            }
        }
        return $processList;
    }

    private function modifyCheck()
    {
        if($this->run){
            throw new RuntimeError('you can not modify configure after init process check');
        }
    }
}
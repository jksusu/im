<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2019-02-25
 * Time: 15:56
 */

namespace EasySwoole\Console;


use EasySwoole\Component\Singleton;
use EasySwoole\Socket\Bean\Caller;
use EasySwoole\Socket\Bean\Response;

class ConsoleModuleContainer
{
    use Singleton;
    private $container = [];

    public function set(ModuleInterface $command)
    {
        $this->container[strtolower($command->moduleName())] = $command;
    }

    function get($key): ?ModuleInterface
    {
        $key = strtolower($key);
        if (isset($this->container[$key])) {
            return $this->container[$key];
        } else {
            return null;
        }
    }

    function getCommandList()
    {
        return array_keys($this->container);
    }


    function hook($actionName, Caller $caller, Response $response)
    {
        $call = ConsoleModuleContainer::getInstance()->get($actionName);
        if ($call instanceof ModuleInterface) {
            $call->exec($caller, $response);
        } else {
            $response->setMessage("action {$actionName} miss");
        }
    }
}
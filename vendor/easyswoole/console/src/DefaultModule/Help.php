<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2019-02-25
 * Time: 16:15
 */

namespace EasySwoole\Console\DefaultModule;


use EasySwoole\Console\ConsoleModuleContainer;
use EasySwoole\Console\ModuleInterface;
use EasySwoole\Socket\Bean\Caller;
use EasySwoole\Socket\Bean\Response;

class Help implements ModuleInterface
{
    function moduleName(): string
    {
        // TODO: Implement moduleName() method.
        return 'help';
    }

    public function exec(Caller $caller, Response $response)
    {
        $args = $caller->getArgs();
        if (!isset($args[0])) {
            $this->help($caller, $response);
        } else {
            $actionName = $args[0];
            $call = ConsoleModuleContainer::getInstance()->get($actionName);
            if ($call instanceof ModuleInterface) {
                $call->help($caller, $response);
            } else {
                $response->setMessage("no help message for command {$actionName} was found.");
            }
        }
    }

    public function help(Caller $caller, Response $response)
    {
        $allCommand = implode(PHP_EOL, ConsoleModuleContainer::getInstance()->getCommandList());
        $help = <<<HELP

Welcome to EasySwoole remote console
Usage: command [action] [...arg] 
For help: help [command] [...arg]
Current command list:

{$allCommand}

HELP;
        $response->setMessage($help);
    }
}
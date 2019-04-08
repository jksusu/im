<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2019-02-25
 * Time: 15:56
 */

namespace EasySwoole\Console;
use EasySwoole\Socket\Bean\Caller;
use EasySwoole\Socket\Bean\Response;

interface ModuleInterface
{
    public function moduleName():string;
    public function exec(Caller $caller,Response $response);
    public function help(Caller $caller,Response $response);
}
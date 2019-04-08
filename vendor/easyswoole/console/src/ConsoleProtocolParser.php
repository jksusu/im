<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2019-02-25
 * Time: 15:53
 */

namespace EasySwoole\Console;


use EasySwoole\Socket\AbstractInterface\ParserInterface;
use EasySwoole\Socket\Bean\Caller;
use EasySwoole\Socket\Bean\Response;

class ConsoleProtocolParser implements ParserInterface
{
    public function decode($raw, $client): ?Caller
    {
        // TODO: Implement decode() method.
        $data = trim($raw);
        $arr = explode(" ",$data);
        $caller = new Caller();
        $caller->setAction(array_shift($arr));
        $caller->setControllerClass(ConsoleTcpController::class);
        $caller->setArgs($arr);
        return $caller;
    }

    public function encode(Response $response, $client): ?string
    {
        // TODO: Implement encode() method.
        $str = $response->getMessage();
        if(empty($str)){
            $str = 'empty response';
        }
        return $str."\r\n";
    }

}
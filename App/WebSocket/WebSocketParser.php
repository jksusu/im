<?php
/**
 * Created by PhpStorm.
 * User: jksusu
 * Date: 2019/2/26
 * Time: 19:52
 */

namespace App\WebSocket;

use EasySwoole\Socket\AbstractInterface\ParserInterface;
use EasySwoole\Socket\Client;
use EasySwoole\Socket\Bean\{
    Caller,
    Response
};
use PhpParser\Node\Stmt\TraitUseAdaptation\Alias;

class WebSocketParser implements ParserInterface
{
    /*
     * 解码
     */
    public function decode($raw, $client): ?Caller
    {
        $caller = new Caller();
        if ($raw !== 'PING') {
            $data = json_decode($raw, true);
            $class = isset($data['controller']) ? $data['controller'] : 'Index';
            $action = isset($data['action']) ? $data['action'] : 'index';
            $params = isset($data['data']) ? $data['data'] : [];
            $controllerClass = "\\App\\WebSocket\\Controller\\" . ucfirst($class);
            if (!class_exists($controllerClass)) {
                $controllerClass = "\\App\\WebSocket\\Controller\\Index";
            }
            //如果没有 token
            /*if (empty($params['data']['token'])) {
                $controllerClass = "\\App\\WebSocket\\Controller\\Index";
                $action = 'token';
            }*/
            //var_dump($params);
            $caller->setClient($raw);
            $caller->setControllerClass($controllerClass);
            $caller->setAction($action);
            $caller->setArgs($params);
        } else {
            $caller->setControllerClass("\\App\\WebSocket\\Controller\\Index");
            $caller->setAction('index');
        }
        return $caller;
    }

    /**
     * encode
     * @param  Response $response Socket Response 对象
     * @param  Client $client Socket Client 对象
     * @return string             发送给客户端的消息
     */
    public function encode(Response $response, $client): ?string
    {
        // 这里返回响应给客户端的信息
        // 这里应当只做统一的encode操作 具体的状态等应当由 Controller处理
        return $response->getMessage();
    }
}
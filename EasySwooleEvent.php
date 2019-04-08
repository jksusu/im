<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/5/28
 * Time: 下午6:33
 */

namespace EasySwoole\EasySwoole;


use EasySwoole\Component\Di;
use EasySwoole\Component\Pool\PoolManager;
use EasySwoole\EasySwoole\Swoole\EventRegister;
use EasySwoole\EasySwoole\AbstractInterface\Event;
use EasySwoole\Http\Request;
use EasySwoole\Http\Response;
use App\Lib\Pool\MysqlPool;
use App\WebSocket\WebSocketParser;
use EasySwoole\Socket\Dispatcher;
use App\WebSocket\WebSocketEvent;
use App\Lib\Pool\RedisPool;
use App\Process\HotReload;
use App\Process\Subscribe;

class EasySwooleEvent implements Event
{

    public static function initialize()
    {
        // TODO: Implement initialize() method.
        date_default_timezone_set('Asia/Shanghai');
        //注册链接池
        PoolManager::getInstance()->register(RedisPool::class, 20);
        PoolManager::getInstance()->register(MySQLPool::class, 20);

    }

    public static function mainServerCreate(EventRegister $register)
    {
        //热重载
        //$swooleServer = ServerManager::getInstance()->getSwooleServer();
        //$swooleServer->addProcess((new HotReload('HotReload', ['disableInotify' => false]))->getProcess());
        //ServerManager::getInstance()->getSwooleServer()->addProcess((new Subscribe('sub'))->getProcess());

        /**
         * *************** WebSocket ***************
         */

        // 创建一个 Dispatcher 配置
        $conf = new \EasySwoole\Socket\Config();
        // 设置 Dispatcher 为 WebSocket 模式
        $conf->setType($conf::WEB_SOCKET);
        // 设置解析器对象
        $conf->setParser(new WebSocketParser());

        // 创建 Dispatcher 对象 并注入 config 对象
        $dispatch = new Dispatcher($conf);

        $websocketEvent = new WebSocketEvent();

        // 给server 注册相关事件
        // 在 WebSocket 模式下  message 事件必须注册 并且交给 Dispatcher 对象处理
        // handshake 事件为自定义握手事件 用于身份验证等
        $register->set(EventRegister::onHandShake, function (\swoole_http_request $request, \swoole_http_response $response) use ($websocketEvent) {
            $websocketEvent->onHandShake($request, $response);
        });
        $register->set(EventRegister::onMessage, function (\swoole_websocket_server $server, \swoole_websocket_frame $frame) use ($dispatch) {
            $dispatch->dispatch($server, $frame->data, $frame);
        });

        $register->set(EventRegister::onClose, function (\swoole_server $server, int $fd, int $reactorId) use ($websocketEvent) {
            $websocketEvent->onClose($server, $fd, $reactorId);
        });

    }

    public static function onRequest(Request $request, Response $response): bool
    {
        // TODO: Implement onRequest() method.

        // TODO: Implement onRequest() method. cors跨域解决方案
        $response->withHeader('Access-Control-Allow-Origin', '*');
        $response->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
        $response->withHeader('Access-Control-Allow-Credentials', 'true');
        $response->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
        if ($request->getMethod() === 'OPTIONS') {
            $response->withStatus(Status::CODE_OK);
            $response->end();
        }
        return true;
    }

    public static function afterRequest(Request $request, Response $response): void
    {
        // TODO: Implement afterAction() method.
    }
}
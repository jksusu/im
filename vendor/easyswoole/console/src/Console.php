<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2019-02-25
 * Time: 15:42
 */

namespace EasySwoole\Console;


use EasySwoole\Component\Singleton;
use EasySwoole\Console\DefaultModule\Help;
use EasySwoole\Socket\Dispatcher;
use Swoole\Server\Port;
use EasySwoole\Socket\Config as DispatcherConfig;

class Console
{
    use Singleton;
    protected $server;
    /** @var Config */
    protected $config;

    final function __construct()
    {
        ConsoleModuleContainer::getInstance()->set(new Help());
    }

    /**
     * @param $server \swoole_server| Port
     * @param $config
     * @throws \Exception
     */
    public function attachServer($server,Config $config)
    {
        $this->config = $config;
        if($server instanceof \swoole_server){
            $this->server = $server;
            $server = $server->addlistener($config->getListenAddress(),$config->getListenPort(),SWOOLE_TCP);
        }
        $server->set(array(
            "open_eof_split" => true,
            'package_eof' => "\r\n",
        ));
        $conf = new DispatcherConfig();
        $conf->setParser(new ConsoleProtocolParser());
        $conf->setType($conf::TCP);
        $dispatcher = new Dispatcher($conf);
        $server->on('receive', function (\swoole_server $server, $fd, $reactor_id, $data) use ($dispatcher) {
            $dispatcher->dispatch($server, $data, $fd, $reactor_id);
        });
        $server->on('connect', function (\swoole_server $server, int $fd, int $reactorId) {
            $hello = 'Welcome to ' . $this->config->getServerName();
            $this->send($fd,$hello);
        });
    }

    public function setServer(\swoole_server $server):Console
    {
        $this->server = $server;
        return $this;
    }

    public function getSwooleServer():?\swoole_server
    {
        return $this->server;
    }

    public function send(int $fd,string $data)
    {
        if($this->server && $this->server->exist($fd)){
            $this->server->send($fd,$data."\r\n");
        }
    }
}
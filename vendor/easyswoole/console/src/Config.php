<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2019-02-25
 * Time: 15:46
 */

namespace EasySwoole\Console;


use EasySwoole\Spl\SplBean;

class Config extends SplBean
{
    protected $serverName = 'EasySwoole Console';

    protected $listenPort = 9500;

    protected $listenAddress = '127.0.0.1';

    /**
     * @return string
     */
    public function getServerName(): string
    {
        return $this->serverName;
    }

    /**
     * @param string $serverName
     */
    public function setServerName(string $serverName): void
    {
        $this->serverName = $serverName;
    }

    /**
     * @return int
     */
    public function getListenPort(): int
    {
        return $this->listenPort;
    }

    /**
     * @param int $listenPort
     */
    public function setListenPort(int $listenPort): void
    {
        $this->listenPort = $listenPort;
    }

    /**
     * @return string
     */
    public function getListenAddress(): string
    {
        return $this->listenAddress;
    }

    /**
     * @param string $listenAddress
     */
    public function setListenAddress(string $listenAddress): void
    {
        $this->listenAddress = $listenAddress;
    }
}
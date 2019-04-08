<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2019-03-03
 * Time: 21:06
 */

namespace EasySwoole\Console;


use EasySwoole\Component\Singleton;

class ConsoleInterceptor
{
    use Singleton;

    protected $list = [];

    public function set(callable $call)
    {
        $this->list = [$call];
        return $this;
    }

    public function add(callable $call)
    {
        $this->list[] = $call;
        return $this;
    }

    public function clear()
    {
        $this->list = [];
        return $this;
    }

    public function list():array
    {
        return $this->list;
    }
}
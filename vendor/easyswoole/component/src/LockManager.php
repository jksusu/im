<?php
/**
 * Created by PhpStorm.
 * User: evalor
 * Date: 2018-12-28
 * Time: 17:08
 */

namespace EasySwoole\Component;

use Swoole\Lock;

class LockManager
{
    use Singleton;

    private $list = [];

    /**
     * 创建一个锁
     * @param string $name 锁名称
     * @param string $type 锁类型
     * @param string $filename 锁定文件 文件锁必须传入
     */
    public function add($name, $type, $filename = null): void
    {
        if (!isset($this->list[$name])) {
            $lock = new Lock($type, $filename);
            $this->list[$name] = $lock;
        }
    }

    /**
     * 获取一个锁
     * @param string $name 锁名称
     * @return Lock|null
     */
    public function get($name): ?Lock
    {
        if (isset($this->list[$name])) {
            return $this->list[$name];
        } else {
            return null;
        }
    }
}
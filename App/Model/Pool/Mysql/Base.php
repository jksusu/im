<?php

namespace App\Model\Pool\Mysql;

use App\Lib\Pool\MysqlObject;
use App\Lib\Pool\MysqlPool;
use EasySwoole\Component\Pool\PoolManager;
use EasySwoole\EasySwoole\Config;

class Base
{
    public $db;

    public function __construct()
    {
        $timeout = Config::getInstance()->getConf('MYSQL');
        $mysqlObject = PoolManager::getInstance()->getPool(MysqlPool::class)->getObj($timeout['POOL_TIME_OUT']);
        // 类型的判定
        if ($mysqlObject instanceof MysqlObject) {
            $this->db = $mysqlObject;
        } else {
            throw new \Exception('Mysql Pool is error');
        }
    }

    public function __destruct()
    {
        if ($this->db instanceof MysqlObject) {
            PoolManager::getInstance()->getPool(MysqlPool::class)->recycleObj($this->db);
            // 请注意 此处db是该链接对象的引用 即使操作了回收 仍然能访问
            // 安全起见 请一定记得设置为null 避免再次使用导致不可预知的问题
            $this->db = null;
        }
    }

}
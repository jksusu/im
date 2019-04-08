<?php
/**
 * Created by PhpStorm.
 * User: jksusu
 * Date: 2019/2/25
 * Time: 17:47
 */

namespace App\Model;

use EasySwoole\Component\Di;

class ModelBase
{
    public $db = "";

    public function __construct()
    {
        if (empty($this->tableName)) {
            throw new \Exception("table error");
        }

        //注入mysql
        $db = Di::getInstance()->get("MYSQL");
        if ($db instanceof \MysqliDb) {
            $this->db = $db;
        } else {
            throw new \Exception("db error");
        }
    }
}
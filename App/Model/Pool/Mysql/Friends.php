<?php
/**
 * Created by PhpStorm.
 * User: jksusu
 * Date: 2019/2/25
 * Time: 17:42
 */

namespace App\Model\Pool\Mysql;


use mysql_xdevapi\Exception;

class Friends extends Base
{
    public $tableName = "friends";



    /**
     * 删除好友/互相删除
     * @param $userId
     * @param $toId
     * @return bool|string
     * @throws \Throwable
     */
    function deleteFriend($userId, $toId)
    {
        try {
            //互相删除
            $this->db->where('chatuser_id', $userId)
                ->where('friend_id', $toId)
                ->delete('friends', 1);
            $this->db->where('chatuser_id', $toId)
                ->where('friend_id', $userId)
                ->delete('friends', 1);
            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
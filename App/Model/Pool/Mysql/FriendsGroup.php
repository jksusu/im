<?php
/**
 * Created by PhpStorm.
 * User: jksusu
 * Date: 2019/2/25
 * Time: 17:42
 */

namespace App\Model\Pool\Mysql;


class FriendsGroup extends Base
{
    public $tableName = "friends_group";

    /**
     * 删除分组
     * @param $uid
     * @param $groupId
     * @return array
     * @throws \Throwable
     */
    function deleteGroup($uid, $groupId)
    {
        $friends = $this->db->where('chatuser_id', $uid)
            ->where('group_id', $groupId)
            ->getOne('friends');
        if ($friends) {
            return ['code' => 202, 'msg' => '请先移除改分组下成员'];
        }
        $delete = $this->db->where('id', $groupId)
            ->where('user_id', $uid)
            ->delete('friends_group', 1);
        if ($delete) {
            return ['code' => 202, 'msg' => '删除失败'];
        } else {
            return ['code' => 200, 'msg' => '删除成功'];
        }
    }

    function deleteAdd($uid, $groupName)
    {
        $data = [
            'group_name' => $groupName,
            'user_id' => $uid,
            'createtime' => time(),
        ];
        $add = $this->db->insert('friends_group', $data);
        if ($add) {
            return ['code' => 200, 'msg' => '创建成功'];
        } else {
            return ['code' => 202, 'msg' => '创建失败'];
        }
    }
}
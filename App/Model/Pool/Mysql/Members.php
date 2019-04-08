<?php
/**
 * Created by PhpStorm.
 * User: jksusu
 * Date: 2019/2/25
 * Time: 17:42
 */

namespace App\Model\Pool\Mysql;


class Members extends Base
{
    public $tableName = "chat_group_user";

    function memberList($groupId)
    {
        $field = 'ct.username,ct.id,ct.avatar,ct.sign';

        $join = 'chat_group_user AS cgu	LEFT JOIN chatuser AS ct ON cgu.user_id = ct.id';

        $members = $this->db->rawQuery(' SELECT ' . $field . ' FROM ' . $join . ' WHERE cgu.group_id = ' . $groupId);

        $return = [
            'code' => 0,
            'msg' => '查询成功',
            'data' => [
                'list' => $members,
            ],
        ];
        return $return;
    }

    /*
     * @param int $groupId 群ID
     * @param int $fromId  发送人ID
     */
    function membersSelect($groupId, $fromId)
    {
        return $this->db->where('group_id', $groupId)
            ->where('status', 3)
            ->where('user_id', $fromId, '!=')
            ->get('chat_group_user', null, 'user_id');
    }
}
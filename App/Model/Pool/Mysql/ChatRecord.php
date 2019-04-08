<?php

namespace App\Model\Pool\Mysql;


class ChatRecord extends Base
{
    public $tableName = 'chat_record';

    /**
     * 写入聊天记录
     * @param $from_id
     * @param $to_id
     * @param $content
     * @param $type
     * @param $need_send
     * @throws \EasySwoole\Mysqli\Exceptions\ConnectFail
     * @throws \EasySwoole\Mysqli\Exceptions\PrepareQueryFail
     * @throws \Throwable
     */
    function addRecord($from_id, $to_id, $content, $type, $need_send)
    {
        $add = [
            'from_id' => $from_id,
            'to_id' => $to_id,
            'content' => $content,
            'type' => $type,
            'need_send' => $need_send,
            'creattime' => time(),
        ];
        $this->db->insert($this->tableName, $add);
    }

    /**
     * 查询聊天记录
     * @param $param
     * @throws \EasySwoole\Mysqli\Exceptions\ConnectFail
     * @throws \EasySwoole\Mysqli\Exceptions\PrepareQueryFail
     * @throws \Throwable
     */
    function selRecord($param)
    {
        $to_id = $param['id'];
        $type = $param['type'] = 'friend' ? 1 : 2;
        $log = $this->db->where('type', $type)
            ->where('from_id', $to_id)
            ->get('chat_record', null);
        $userData = $this->db->where('id', $to_id)->getOne('chatuser', 'id,username,avatar,email,sign');
    }
}
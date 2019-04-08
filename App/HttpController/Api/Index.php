<?php
namespace App\HttpController\Api;

use App\Model\Pool\Mysql\ChatRecord;
use App\Model\Pool\Mysql\ChatUser;
use App\Model\Pool\Mysql\Members;

class Index extends Base
{
    /**
     * 初始化查询各种列表
     * @return bool
     * @throws \Throwable
     */
    public function init()
    {
        $this->params = $this->request()->getRequestParam();
        $user = new ChatUser();
        $data = $user->friendList($this->params['uid']);
        return $this->apiReturn($data);
    }

    /*
     * 查看群成员
     * @param int groupId 群ID
     */
    function getMembers()
    {
        $params = $this->request()->getRequestParam();
        $members = new Members();
        $memberList = $members->memberList($params['id']);
        return $this->apiReturn($memberList);
    }

    //修改名字
    function nickname()
    {
        $nickname = '测试';
        $userId = 1;
        $user = new ChatUser();
        $user->db->rawQuery('update chatuser set  nickname=' . $nickname . ' where id =' . $userId);
    }

    /**
     * 查询聊天记录
     * @throws \EasySwoole\Mysqli\Exceptions\ConnectFail
     * @throws \EasySwoole\Mysqli\Exceptions\PrepareQueryFail
     * @throws \Throwable
     */
    function selRecord()
    {
        $param = $this->request()->getRequestParam();
        $user = new ChatRecord();
        $user->selRecord($param);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: jksusu
 * Date: 2019/3/20
 * Time: 22:19
 */

namespace App\HttpController\Api;

class AddAction extends Base
{
    /**
     * 加好友加群查询
     * @return bool
     * @throws \Throwable
     */
    function selFriends()
    {
        $params = $this->request()->getRequestParam();
        $friend = new \App\Model\Pool\Mysql\AddAction();
        if ($params['type'] == 1) {
            $return = $friend->selFriends($params);
        } elseif ($params['type'] == 2) {
            $return = $friend->selGroup($params);
        }
        if (empty($return)) {
            $data = [
                'code' => 202,
                'msg' => '没有数据',
            ];
            return $this->apiReturn($data);
        } else {
            $data = [
                'code' => 200,
                'msg' => '查询成功',
                'data' => [
                    'title' => 'haoyou',
                    'list' => $return
                ],
            ];
            return $this->apiReturn($data);
        }
    }

    /**
     * @param int type(1 == 添加好友 2 == 添加群)
     * @param int id 被添加人ID 或者群ID
     * @throws \EasySwoole\Mysqli\Exceptions\ConnectFail
     * @throws \EasySwoole\Mysqli\Exceptions\PrepareQueryFail
     * @throws \Throwable
     */
    function friendAdd()
    {
        $params = $this->request()->getRequestParam();
        $user = new \App\Model\Pool\Mysql\AddAction();
        $user->friendAdd($params['type'], $params['id'], $params['uid'], $params['groupId'], $params['remark']);
        $this->apiReturn(['code' => 200, 'message' => '添加消息已发送']);
    }

    /**
     * 消息盒子列表
     */
    function message()
    {
        $params = $this->request()->getRequestParam();
        $user = new \App\Model\Pool\Mysql\AddAction();
        $data = $user->messageBox($params);
        if (!empty($data)) {
            $this->apiReturn($data);
        } else {
            $this->apiReturn(['code' => 202]);
        }
    }

    /**
     * 同意或拒绝被添加好友
     * @throws \EasySwoole\Mysqli\Exceptions\ConnectFail
     * @throws \EasySwoole\Mysqli\Exceptions\PrepareQueryFail
     * @throws \Throwable
     */
    function addFriends()
    {
        $params = $this->request()->getRequestParam();
        $user = new \App\Model\Pool\Mysql\AddAction();
        $data = $user->addFriends($params);
        if ($data) {
            $this->apiReturn(['code' => 200, 'message' => '操作成功']);
        } else {
            $this->apiReturn(['code' => 202, 'message' => '添加失败']);
        }
    }

}
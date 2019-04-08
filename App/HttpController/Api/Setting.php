<?php
/**
 * Created by PhpStorm.
 * User: jksusu
 * Date: 2019/3/14
 * Time: 15:41
 */

namespace App\HttpController\Api;


use App\Model\Pool\Mysql\Friends;
use App\Model\Pool\Mysql\FriendsGroup;
use EasySwoole\Validate\Validate;

class Setting extends Base
{
    function index()
    {
    }

    /**
     * 好友备注修改
     * @param int uid 用户ID
     * @param int toId 好友ID
     * @param string remarks 备注
     * @return bool
     * @throws \Throwable
     */
    function remarksSave()
    {
        $params = $this->request()->getRequestParam();
        $validate = new Validate();
        $validate->addColumn('uid')->required('参数必传');
        $validate->addColumn('toId')->required('参数必传');
        $validate->addColumn('remarks')->required('参数必传');
        if (!$validate->validate($params)) {
            return $this->writeJson(202, '', 'error');
        }
        $friend = new Friends();
        $save = $friend->db
            ->where('chatuser_id', $params['uid'])
            ->where('friend_id', $params['toId'])
            ->update('friends', ['remarks' => $params['remarks']]);
        if ($save) {
            return $this->writeJson(200, '', '修改成功');
        } else {
            return $this->writeJson(202, '', '修改失败');
        }
    }

    /**
     * 删除好友/互相删除
     * @return bool
     * @throws \Throwable
     */
    function friendDelete()
    {
        $params = $this->request()->getRequestParam();
        $validate = new Validate();
        $validate->addColumn('uid')->required('参数必传');
        $validate->addColumn('toId')->required('参数必传');
        if (!$validate->validate($params)) {
            return $this->writeJson(202, '', 'error');
        }
        $friend = new Friends();
        $delete = $friend->deleteFriend($params['uid'], $params['toId']);
        if ($delete) {
            return $this->writeJson(200, '', '删除成功');
        } else {
            return $this->writeJson(202, '', '删除失败');
        }
    }

    /**
     * 分组重命名
     * @param int uid 当前用户ID
     * @param int groupId 分组ID
     * @param string remarks 重命名
     * @return bool
     * @throws \Throwable
     */
    function groupSave()
    {
        $params = $this->request()->getRequestParam();
        $validate = new Validate();
        $validate->addColumn('uid')->required('参数必传');
        $validate->addColumn('groupId')->required('参数必传');
        $validate->addColumn('remarks')->required('参数必传');
        if (!$validate->validate($params)) {
            return $this->writeJson(202, '', 'error');
        }
        $friends = new FriendsGroup();
        $update = $friends->db
            ->where('user_id', $params['uid'])
            ->where('id', $params['groupId'])
            ->update('friends_group', ['group_name' => $params['remarks']]);

        if ($update) {
            return $this->writeJson(200, '', '修改成功');
        } else {
            return $this->writeJson(202, '', '修改失败');
        }
    }

    /**
     * 删除分组
     * @param int uid 当前用户ID
     * @param int groupId 分组ID
     * @return bool
     * @throws \Throwable
     */
    function groupDelete()
    {
        $params = $this->request()->getRequestParam();
        $validate = new Validate();
        $validate->addColumn('uid')->required('参数必传');
        $validate->addColumn('groupId')->required('参数必传');
        if (!$validate->validate($params)) {
            return $this->writeJson(202, '', 'error');
        }
        $friends = new FriendsGroup();
        $return = $friends->deleteGroup($params['uid'], $params['groupId']);
        return $this->apiReturn($return);
    }

    /**
     * 创建分组
     * @param int uid 当前用户ID
     * @param int groupName 分组名字
     * @return bool
     * @throws \Throwable
     */
    function groupAdd()
    {
        $params = $this->request()->getRequestParam();
        $validate = new Validate();
        $validate->addColumn('uid')->required('参数必传');
        $validate->addColumn('groupName')->required('参数必传');
        if (!$validate->validate($params)) {
            return $this->writeJson(202, '', 'error');
        }
        $friends = new FriendsGroup();
        $return = $friends->deleteAdd($params['uid'], $params['groupName']);
        return $this->apiReturn($return);
    }

    /**
     * 更新签名
     * @throws \EasySwoole\Mysqli\Exceptions\ConnectFail
     * @throws \EasySwoole\Mysqli\Exceptions\PrepareQueryFail
     * @throws \Throwable
     */
    function autograph()
    {
        $params = $this->request()->getRequestParam();
        $user = new \App\Model\Pool\Mysql\ChatUser();
        $user->db->where('id', $params['uid'])->update('chatuser', ['sign' => $params['sign']]);
    }
}
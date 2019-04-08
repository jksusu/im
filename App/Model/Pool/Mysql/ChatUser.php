<?php
/**
 * Created by PhpStorm.
 * User: jksusu
 * Date: 2019/2/25
 * Time: 17:42
 */

namespace App\Model\Pool\Mysql;


class ChatUser extends Base
{
    public $tableName = "chatuser";

    /**
     * 初始化
     * @param $userId
     * @return array|string
     * @throws \Throwable
     */
    public function friendList($userId)
    {
        try {
            //获取用户数据
            $userData = $this->db->where('id', $userId)
                ->getOne($this->tableName, 'id,username,status,sign,avatar');

            //查询群组
            $field = 'cg.id,cg.group_name,cg.group_avatar';
            $where = 'user_id = ' . $userId;
            $join = 'chat_group  AS cg LEFT JOIN  chat_group_user AS cgu ON cgu.group_id=cg.id';
            $group = $this->db->rawQuery('SELECT ' . $field . ' FROM ' . $join . ' WHERE ' . $where);

            //我的分组设置数据
            $fri = 'group_id,chatuser_id, GROUP_CONCAT(friend_id)';
            $list = $this->db->rawQuery("SELECT $fri FROM friends  where chatuser_id= $userId GROUP BY group_id");
            $friendData = [];
            foreach ($list as $key => $val) {
                $friendData[$key]['groupname'] = $this->db->where('id', $val['group_id'])->getValue('friends_group', 'group_name');
                $friendData[$key]['id'] = $val['group_id'];
                $friendData[$key]['online'] = 2;
                $friendData[$key]['list'] = $this->db->whereIn('id', $val['GROUP_CONCAT(friend_id)'])->get($this->tableName, null, 'id,username,status,sign,avatar');
            }
            $return = [
                'code' => 0,
                'msg' => '查询成功',
                'data' => [
                    'mine' => $userData,
                    'friend' => $friendData,
                    'group' => $group,
                ],
            ];
            return $return;

        } catch (\Exception $e) {
            return '获取用户好友信息失败' . $e->getMessage();
        }
    }

    /*
     * 注册用户
     * @param  array params 参数
     */
    function register($params)
    {
        $isRegister = $this->db->where('username', $params['username'])->getOne('chatuser');
        if ($isRegister) {
            return ['code' => 203, 'message' => '该用户名已注册'];
        }

        $userInfo = [
            'username' => $params['username'],
            'password' => md5($params['password']),
            'email' => $params['email'],
            'avatar' => $this->avatar(),
            'createtime' => time(),
        ];
        $isAdd = $this->db->insert('chatuser', $userInfo);
        if ($isAdd) {
            $this->addDeveloper($params);
            return ['code' => 200, 'message' => '注册成功'];
        } else {
            return ['code' => 202, 'message' => '注册失败'];
        }
    }

    /**
     * 添加开发者添加默认分组
     * @param $params
     * @throws \EasySwoole\Mysqli\Exceptions\ConnectFail
     * @throws \EasySwoole\Mysqli\Exceptions\PrepareQueryFail
     * @throws \Throwable
     */
    function addDeveloper($params)
    {
        $id = $this->db->where('username', $params['username'])->getOne('chatuser', 'id');
        //添加一个默认好友的分组
        $group = [
            'group_name' => '默认分组',
            'user_id' => $id['id'],
            'createtime' => time(),
        ];
        if ($this->db->insert('friends_group', $group)) {
            //我的分组ID
            $groupId = $this->db->getInsertId();
            //添加开发者好友
            $addFr = [
                'chatuser_id' => $id['id'],
                'friend_id' => 7,
                'group_id' => $groupId,
                'remarks' => 'gollum开发者',
                'createtime' => time(),
            ];
            $this->db->insert('friends', $addFr);
            //开发者添加当前用户
            $thisUser = [
                'chatuser_id' => 7,
                'friend_id' => $id['id'],
                'group_id' => 6,
                'remarks' => $params['username'],
                'createtime' => time(),
            ];
            $this->db->insert('friends', $thisUser);
        }
    }

    //随机更新一张头像
    function avatar(): string
    {
        $avatarArray = [
            'http://p19.qhimg.com/bdm/480_296_0/t01648cc26c003cdb0b.jpg',
            'http://p15.qhimg.com/bdm/480_296_0/t0184553137052bf866.jpg',
            'http://p16.qhimg.com/bdm/960_593_0/t014d980d568df4c92d.jpg',
            'http://p16.qhimg.com/bdm/480_296_0/t013727104fdfe5d815.jpg',
            'http://p19.qhimg.com/bdm/480_296_0/t01ccd91eda9f4010a5.jpg',
            'http://p19.qhimg.com/bdm/480_296_0/t0194849aa1825e5075.jpg',
            'http://p15.qhimg.com/bdm/480_296_0/t01fa565ac0ae947f93.jpg',
            'http://p15.qhimg.com/bdm/480_296_0/t01fa565ac0ae947f93.jpg',
            'http://p17.qhimg.com/bdm/480_296_0/t013209e68165407af7.jpg',
        ];
        $number = array_rand($avatarArray, 1);
        return $avatarArray[$number];
    }
}
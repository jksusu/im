<?php
/**
 * Created by PhpStorm.
 * User: jksusu
 * Date: 2019/3/20
 * Time: 22:21
 */

namespace App\Model\Pool\Mysql;

use App\Lib\Redis;

class AddAction extends Base
{
    /**
     * 查找可以添加的好友
     * @param $params
     * @return mixed|string
     * @throws \Throwable
     */
    function selFriends($params)
    {
        if (!empty($params['val'])) {
            $where['username'] = ['like', $params['val']];
        }
        try {
            //查询我的好友列表
            $myFriends = $this->db
                ->where('chatuser_id', $params['uid'])
                ->get('friends', null, 'friend_id');
            //所有注册人员
            $friends = $this->db
                ->where('id', $params['uid'], '!=')
                ->get('chatuser', null, 'id');
            $ids = $this->str($myFriends, $friends);
            //没有好友添加
            if (empty($ids)) {
                return null;
            }
            //查询我能添加的好友
            return $this->db->whereIn('id', $ids)
                ->get('chatuser', '15', 'id,username,avatar,sign');
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    /**
     * 查找可以添加的群
     * @param $params
     * @return \EasySwoole\Mysqli\Mysqli|mixed|null|string
     * @throws \Throwable
     */
    function selGroup($params)
    {
        if (!empty($params['val'])) {
            $where = ['username', 'like', $params['val']];
        }
        try {
            //查询我的好友列表
            $myGroup = $this->db
                ->where('user_id', $params['uid'])
                ->get('chat_group_user', null, 'group_id');
            //所有注册人员
            $group = $this->db->get('chat_group', null, 'id');

            $ids = $this->str($myGroup, $group);
            //没有群
            if (empty($ids)) {
                return null;
            }
            //查询我能添加的好友
            return $this->db->whereIn('id', $ids)
                ->get('chat_group', '15', 'id,username,avatar,sign');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * 发送添加好友添加群聊请求
     * @param $type
     * @param $id
     * @param $userId
     * @param $group_id
     * @param $remarks
     * @throws \EasySwoole\Mysqli\Exceptions\ConnectFail
     * @throws \EasySwoole\Mysqli\Exceptions\PrepareQueryFail
     * @throws \Throwable
     */
    function friendAdd($type, $id, $userId, $group_id, $remarks)
    {
        //添加朋友
        if ($type == 1) {
            $apply = [
                'apply_uid' => $userId,
                'to_id' => $id,
                'remark' => $remarks,
                'status' => 1,
                'friend_group_id' => $group_id,
                'type' => 1,
                'creattime' => time(),
            ];
            $isHave = $this->db
                ->where('apply_uid', $userId)
                ->where('to_id', $id)
                ->getOne('apply');
            //调用推送方法
            $miDate = $this->db
                ->where('id', $userId)
                ->getOne('chatuser', 'id,username,status,sign,avatar');
            //发布一个添加请求
            $this->selIsOnLive($miDate, $id);
            if (empty($isHave)) {
                $this->db->insert('apply', $apply);
            }
        }
        //添加群
        if ($type == 2) {
            $apply = [
                'apply_uid' => $userId,
                'to_id' => $id,
                'remark' => $remarks,
                'status' => 2,
                'type' => 1,
                'creattime' => time(),
            ];
            $this->db->insert('apply', $apply);
        }
    }

    /*
     * 去掉我的好友
     * @return string 去重后的字符串，逗号隔开
     */
    function str(array $oneData, array $towData): string
    {
        //转一维数组
        $one = [];
        array_map(function ($value) use (&$one) {
            $one = array_merge($one, array_values($value));
        }, $oneData);

        $tow = [];
        array_map(function ($value) use (&$tow) {
            $tow = array_merge($tow, array_values($value));
        }, $towData);
        //得到差集，返回值
        $ids = array_values(array_diff($tow, $one));
        $return = '';
        //转字符串去重
        foreach ($ids as $val) {
            $return .= $val . ',';
        }
        return rtrim($return, ',');
    }

    /**
     * 发布添加好友的消息
     * @param $miDate
     * @param $toId
     */
    function selIsOnLive($miDate, $toId)
    {
        $data = [
            'userInfo' => $miDate,
            'toId' => $toId,
        ];
        $redis = Redis::getInstance()->connect();
        $data = json_encode($data);
        echo 'AddAction 172 行，发布添加 ID =' . $toId . ' 好友的消息成功' . PHP_EOL;
        $redis->publish('addFriends', $data);
    }

    /**
     * 消息盒子列表
     * @param $params
     * @return false|string
     * @throws \EasySwoole\Mysqli\Exceptions\ConnectFail
     * @throws \EasySwoole\Mysqli\Exceptions\PrepareQueryFail
     * @throws \Throwable
     */
    function  messageBox($params)
    {
        $box = $this->db
            ->where('to_id', $params['uid'])
            ->where('status', 1)
            ->where('type', 1)
            ->get('apply', '15');
        if (empty($box)) {
            return null;
        }
        $userData = [];
        foreach ($box as $key => $val) {
            $userData[$key]['applyId'] = $val['id'];
            $userData[$key]['content'] = '申请添加你为好友';
            $userData[$key]['uid'] = $val['apply_uid'];
            $userData[$key]['remark'] = $val['remark'];
            $userData[$key]['time'] = date('Y-m-d H:i:s', $val['creattime']);
            $userData[$key]['from'] = $val['apply_uid'];
            $userData[$key]['user'] = $this->db
                ->where('id', $val['apply_uid'])
                ->getOne('chatuser', 'id,username,avatar,sign');
        }
        $data = [
            'code' => 0,
            'pages' => 1,
            'data' => $userData
        ];

        return $data;
    }

    /**
     * 同意或拒绝被添加好友
     * @param $params
     * @return bool
     * @throws \EasySwoole\Mysqli\Exceptions\ConnectFail
     * @throws \EasySwoole\Mysqli\Exceptions\PrepareQueryFail
     * @throws \Throwable
     */
    function addFriends($params):bool
    {
        //同意
        if ($params['status'] == 1) {
            $addInfo = $this->db->where('id', $params['applyId'])->getOne('apply');
            $this->db->where('id', $params['applyId'])->update('apply', ['status' => 3]);
            //添加到我的好友列表
            $we = [
                'chatuser_id' => $addInfo['to_id'],
                'friend_id' => $addInfo['apply_uid'],
                'group_id' => $params['group'],
                'createtime' => time(),
            ];
            //给我对方添加我
            $to = [
                'chatuser_id' => $addInfo['apply_uid'],
                'friend_id' => $addInfo['to_id'],
                'group_id' => $addInfo['friend_group_id'],
                'createtime' => time(),
            ];
            $this->db->insert('friends', $we);
            $this->db->insert('friends', $to);
            return true;
        } else {
            $this->db->where('id', $params['applyId'])
                ->update('apply', ['status' => 2,'updatetime'=>time()]);
            return true;
        }
    }
}
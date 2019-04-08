<?php
/**
 * Created by PhpStorm.
 * User: jksusu
 * Date: 2019/2/26
 * Time: 20:41
 */

namespace App\WebSocket\Controller;

use App\Lib\Redis;
use App\Model\Pool\Mysql\ChatUser;
use EasySwoole\EasySwoole\ServerManager;
use EasySwoole\EasySwoole\Swoole\Task\TaskManager;
use EasySwoole\Socket\AbstractInterface\Controller;

class Message extends Controller
{
    function index()
    {
    }

    /*
     * 收到消息事件
     */
    public function chatMessage()
    {
        $data = $this->caller()->getArgs();
        switch ($data['to']['type']) {
            case 'friend':
                echo '用户' . $data['mine']['username'] . '发送 =' . $data['mine']['content'] . ' 给用户 ' . $data['to']['id'] . PHP_EOL;
                $fromId = $data['mine']['id'];//发送ID
                $fromUsername = $data['mine']['username'];//发送用户名
                $fromAvatar = $data['mine']['avatar'];//来源头像
                $toId = $data['to']['id'];//接受ID
                $toContent = $data['mine']['content'];//内容
                $type = $data['to']['type'];//类型
                $this->pushFriend($fromId, $fromUsername, $fromAvatar, $toId, $toContent, $type);
                break;
            case 'group':
                $fromUsername = $data['mine']['username'];//消息来源用户名
                $avatar = $data['mine']['avatar'];//消息来源头像
                $groupId = $data['to']['id'];//消息的来源ID（如果是私聊，则是用户id，如果是群聊，则是群组id）
                $fromType = $data['to']['type'];//聊天窗口来源类型，从发送消息传递的to里面获取
                $toContent = $data['mine']['content'];//内容
                $mine = false;//是否我发送的消息，如果为true，则会显示在右方
                $fromId = $data['mine']['id'];//消息的发送者id（比如群组中的某个消息发送者），可用于自动解决浏览器多窗口时的一些问题
                $timestamp = time() * 1000;
                $this->pushGroup($fromUsername, $groupId, $fromType, $toContent, $mine, $fromId, $timestamp, $avatar);
                break;

        }
    }

    /**
     * 单聊推送服务
     * @param $fromId
     * @param $fromUsername
     * @param $fromAvatar
     * @param $toId
     * @param $toContent
     * @param $type
     * @throws \Exception
     */
    public function pushFriend($fromId, $fromUsername, $fromAvatar, $toId, $toContent, $type)
    {
        $server = ServerManager::getInstance()->getSwooleServer();
        //查询 $toId 当前是否在线
        $redis = Redis::getInstance()->connect();
        $toInfo = $redis->get($toId);
        $addRecord = new  \App\Model\Pool\Mysql\ChatRecord();
        if (!empty($toInfo) and !empty($toInfo['fd'])) {
            //当前 fd 有效
            if ($server->isEstablished($toInfo['fd'])) {
                //推送消息
                $push = [
                    'msgType' => 'chatMessage',
                    'data' => [
                        'username' => $fromUsername,//来源用户名
                        'avatar' => $fromAvatar,//来源头像
                        'id' => $fromId,//来源id
                        'type' => $type,
                        'content' => $toContent,
                        'timestamp' => time() * 1000,

                    ]
                ];
                $dd = json_encode($push);
                $server->push($toInfo['fd'], $dd);
                //写入聊天记录
                $addRecord->addRecord($fromId, $toId, $toContent, 1, 0);
            }
        } else {
            $addRecord->addRecord($fromId, $toId, $toContent, 1, 1);
            echo '你的好友不在线 已记录' . $toId . PHP_EOL;
        }
    }


    //群消息推送
    function pushGroup($fromUsername, $groupId, $fromType, $toContent, $mine, $fromId, $timestamp, $avatar)
    {
        echo '群聊推送' . PHP_EOL;
        //查询当前群在线群成员
        $groupStr = new  \App\Model\Pool\Mysql\Members();
        //群成员
        $groupList = $groupStr->membersSelect($groupId, $fromId);
        $server = ServerManager::getInstance()->getSwooleServer();
        $redis = Redis::getInstance()->connect();
        //聊天记录
        $addRecord = new  \App\Model\Pool\Mysql\ChatRecord();
        foreach ($groupList as $key => $val) {
            $user = $redis->get($val['user_id']);
            //检查当前链接是否有效
            if (!empty($user['fd']) and $server->isEstablished($user['fd'])) {
                $data = [
                    'msgType' => 'chatMessage',
                    'data' => [
                        'username' => $fromUsername,
                        'avatar' => $avatar,
                        'id' => $groupId,//群组ID
                        'type' => $fromType,
                        'content' => $toContent,
                        'mine' => $mine,
                        'fromid' => $fromId,
                        'timestamp' => $timestamp,
                    ]
                ];
                $push = json_encode($data);
                $addRecord->addRecord($fromId, $groupId, $toContent, 2, 0);
                echo '推送群消息 = ' . $user['fd'] . '用户名' . PHP_EOL;
                $server->push($user['fd'], $push);
            } else {
                //$addRecord->addRecord($fromId, $groupId, $toContent, 1, 2);
                echo '用户ID = ' . $val['user_id'] . '不在线，推送失败' . PHP_EOL;
            }
        }

    }

    /*
     *链接socket 建立映射关系，如果没有查到当前 token 缓存 直接发送消息下线
     */
    public function bind()
    {
        $data = $this->caller()->getArgs();
        $redis = Redis::getInstance()->connect();
        $oldInfo = $redis->get($data['uid']);
        if (!empty($oldInfo)) {
            $newInfo = [
                'id' => $oldInfo['id'],
                'username' => $oldInfo['username'],
                'nickname' => $oldInfo['username'],
                'sign' => $oldInfo['sign'],
                'avatar' => $oldInfo['avatar'],
                'fd' => $this->caller()->getClient()->getFd(),
            ];
            $redis->set($data['uid'], $newInfo, 3600);
            //控制台提示
            echo 'id = ' . $data['uid'] . '    user == ' . $oldInfo['username'] . '  的用户,绑定了客户端,fd ===' . $this->caller()->getClient()->getFd() . PHP_EOL;
        } else {
            $response = [
                'msgType' => 'logout'
            ];
            echo '您的uid过期' . $data['uid'] . PHP_EOL;
            $this->response()->setMessage(json_encode($response));
        }
    }

    /**
     * 加好友加群推送
     * @param $type
     * @param $message
     */
    function addPush($type, $message)
    {
        $server = ServerManager::getInstance()->getSwooleServer();
        $redis = Redis::getInstance()->connect();
        $toInfo = $redis->get($message['toId']);
        echo '推送消息给客户' . PHP_EOL;
        //加好友推送
        if ($type === 1 and isset($toInfo)) {
            if ($server->isEstablished($message['fd'])) {
                //推送消息
                $push = [
                    'msgType' => 'addFriendEvent',
                    'data' => [
                        'type' => 'friends',//来源用户名
                        'username' => $message['userInfo']['username'],//来源用户名
                        'avatar' => $userInfo['avatar'],//来源id
                    ]
                ];
                $dd = json_encode($push);
                echo '推送加好友消息 fd =' . $toUserInfo['fd'];
                var_dump($push);
                $server->push($toUserInfo['fd'], $dd);
                //写入聊天记录
            } else {
                echo '不存在用户信息';
            }
        }
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: jksusu
 * Date: 2019/2/25
 * Time: 13:41
 */

namespace App\HttpController\Api;

use App\Lib\Redis;
use Co\Mysql;
use EasySwoole\Http\AbstractInterface\Controller;
use EasySwoole\Http\Message\Status;
use EasySwoole\Validate\Validate;

class Login extends Controller
{

    function index()
    {
    }

    function register()
    {
        $params = $this->request()->getRequestParam();
        $register = new \App\Model\Pool\Mysql\ChatUser();
        $return = $register->register($params);
        if ($return['code'] === 200) {
            return $this->writeJson(200, '', '注册成功');
        } else {
            return $this->writeJson($return['code'], '', $return['message']);
        }

    }

    function login()
    {
        $params = $this->request()->getRequestParam();
        $validate = new Validate();
        $validate->addColumn('username')->required('用户名必填');
        $validate->addColumn('password')->required('密码必传');
        if (!$validate->validate($params)) {
            return $this->writeJson(Status::CODE_BAD_REQUEST, $validate->getError()->__toString(), 'error');
        }
        $chatUser = new \App\Model\Pool\Mysql\ChatUser();
        $userData = $chatUser->db->where('username', $params['username'])->getOne('chatuser', 'id,username,password,nickname,avatar,sign');
        if (empty($userData)) {
            return $this->writeJson(202, '', '此账号不存在');
        }
        $redis = Redis::getInstance()->connect();
        if (isset($userData) && $userData['password'] === md5($params['password'])) {
            $userInfo = [
                'id' => $userData['id'],
                'username' => $userData['username'],
                'nickname' => $userData['username'],
                'sign' => $userData['sign'],
                'avatar' => $userData['avatar'],
            ];
            $redis->set($userData['id'], $userInfo, 10000);
            echo '用户名 = ' . $userData['username'] . '   id === ' . $userData['id'] . ' 登录成功 ' . PHP_EOL;
            return $this->writeJson(200, $userInfo, '登录成功');
        } else {
            return $this->writeJson(202, '', '账号密码错误');
        }
    }

    function getToken()
    {
        //strtoupper转换成全大写的
        $charid = strtoupper(md5(uniqid(mt_rand(), true)));
        return substr($charid, 0, 8) . substr($charid, 8, 4) . substr($charid, 12, 4) . substr($charid, 16, 4) . substr($charid, 20, 12);
    }
}
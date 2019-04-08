<?php
/**
 * Created by PhpStorm.
 * User: jksusu
 * Date: 2019/2/25
 * Time: 13:41
 */

namespace App\HttpController\Api;

use EasySwoole\Http\AbstractInterface\Controller;

class Base extends Controller
{
    public $params = [];

    function index()
    {
    }

    /*    function __construct()
        {
            $this->params = $this->request()->getRequestParam();
            return $this->writeJson('200', 'll');
        }*/

    /*
     * 获取配置
     */
    function getConfig($fileName, $configName)
    {
        $conf = \Yaconf::get($fileName . $configName);
        if (\Yaconf::has($fileName . $configName)) {
            return $conf;
        } else {
            return false;
        }
    }

    function apiReturn($return)
    {
        if (!$this->response()->isEndResponse()) {
            $this->response()->write(json_encode($return, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            $this->response()->withHeader('Content-type', 'application/json;charset=utf-8');
            $this->response()->withStatus(200);
            return true;
        } else {
            return false;
        }
    }
}
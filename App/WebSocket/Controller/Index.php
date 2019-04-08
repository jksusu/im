<?php
/**
 * Created by PhpStorm.
 * User: jksusu
 * Date: 2019/3/1
 * Time: 14:00
 */

namespace App\WebSocket\Controller;

use EasySwoole\Socket\AbstractInterface\Controller;


class Index extends Controller
{
    function index()
    {
        echo '链接错误，请重新链接' . PHP_EOL;
    }

    function token()
    {
        echo 'token 失效或者程序出错，请联系作者 jksusuppx@gmail.com';
    }
}
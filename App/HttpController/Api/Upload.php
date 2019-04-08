<?php
/**
 * Created by PhpStorm.
 * User: jksusu
 * Date: 2019/2/25
 * Time: 13:41
 */

namespace App\HttpController\Api;

use App\Lib\ClassArr;
use EasySwoole\EasySwoole\Config;
use Qcloud\Cos\Client;

class Upload extends Base
{
    function index()
    {
    }

    function autograph()
    {
        $request = $this->request();
        $files = $request->getSwooleRequest()->files;
        $types = array_keys($files);
        $type = $types[0];
        if (empty($type)) {
            return $this->writeJson(400, '上传文件不合法');
        }

        try {
            $classObj = new ClassArr();
            $classStats = $classObj->uploadClassStat();
            $uploadObj = $classObj->initClass($type, $classStats, [$request, $type]);
            $file = $uploadObj->upload();
        } catch (\Exception $e) {
            return $this->writeJson(400, '', $e->getMessage());
        }
        if (empty($file)) {
            return $this->writeJson(400, '', '上传失败');
        }

        $data = [
            'code' => 0,
            'msg' => '上传成功',
            'data' => [
                'src' => $file,
            ],
        ];
        $da = json_encode($data);
        return $this->apiReturn($da);
    }
}
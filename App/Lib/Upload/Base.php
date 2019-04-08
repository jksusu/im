<?php

namespace App\Lib\Upload;

use EasySwoole\EasySwoole\Config;
use Qcloud\Cos\Client;

class Base
{

    /**
     * 上传文件的 file - key
     * @var string
     */
    public $type = "";

    function __construct($request, $type = null)
    {
        $this->request = $request;
        if (empty($type)) {
            $files = $this->request->getSwooleRequest()->files;
            $types = array_keys($files);
            $this->type = $types[0];
        } else {
            $this->type = $type;
        }
    }


    public function upload()
    {
        if ($this->type != $this->fileType) {
            return false;
        }

        $videos = $this->request->getUploadedFile($this->type);

        $this->size = $videos->getSize();
        $this->checkSize();
        $fileName = $videos->getClientFileName();

        $this->clientMediaType = $videos->getClientMediaType();

        $this->checkMediaType();

        $file = $this->getFile($fileName);

        $flag = $videos->moveTo($file);
        if (!empty($flag)) {
            return $this->file;
        }

        return false;

    }

    public function getFile($fileName)
    {
        $pathinfo = pathinfo($fileName);
        $extension = $pathinfo['extension'];

        $dirname = "/" . $this->type . "/" . date("Y") . "/" . date("m");
        $dir = EASYSWOOLE_ROOT . "/Webroot" . $dirname;
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $basename = "/" . $this->getFileKey($fileName) . "." . $extension;

        $this->file = $dirname . $basename;
        return $dir . $basename;

    }

    /*
     * [checkMediaType description]
     * @auth   singwa
     * @date   2018-10-20T23:53:08+0800
     * @return [type]                   [description]
     */
    public function checkMediaType()
    {
        $clientMediaType = explode("/", $this->clientMediaType);
        $clientMediaType = $clientMediaType[1] ?? "";
        if (empty($clientMediaType)) {
            throw new \Exception("上传{$this->type}文件不合法");
        }
        if (!in_array($clientMediaType, $this->fileExtTypes)) {
            throw new \Exception("上传{$this->type}文件不合法");
        }

        return true;
    }

    public function checkSize()
    {
        if (empty($this->size)) {
            return false;
        }

        // todo
    }

    /**
     * 生成的唯一性key
     * @param string $str
     * @return string
     */
    public static function getFileKey($str)
    {
        return substr(md5(self::makeRandomString() . $str . time() . rand(0, 9999)), 8, 16);
    }

    /**
     * 生成随机字符串
     * @param string length 长度
     * @return string 生成的随机字符串
     */
    public static function makeRandomString($length = 1)
    {

        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;

        for ($i = 0; $i < $length; $i++) {
            $str .= $strPol[rand(0, $max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }
        return $str;
    }

}
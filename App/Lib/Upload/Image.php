<?php

namespace App\Lib\Upload;

use EasySwoole\EasySwoole\Config;
use Qcloud\Cos\Client;

class Image extends Base
{

    /**
     * fileType
     * @var string
     */
    //public $fileType = "image";
    public $fileType = "file";

    public $maxSize = 122;

    /**
     * 文件后缀的medaiTypw
     * @var [type]
     */
    public $fileExtTypes = [
        'png',
        'jpeg',
        // todo
    ];
}
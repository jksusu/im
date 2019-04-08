<?php

namespace App\Lib;

class ClassArr
{

    /**
     * 类库地址
     * @return array
     */
    public function uploadClassStat()
    {
        return [
            "file" => "\App\Lib\Upload\Image",
        ];
    }

    /**
     * @param string  type 文件类型
     * @param array supportedClass 类库配置数组
     * @param array params  参数
     * @param bool needInstance 是否需要实例化
     * @return bool|object
     * @throws \ReflectionException
     */
    public function initClass($type, $supportedClass, $params = [], $needInstance = true)
    {
        if (!array_key_exists($type, $supportedClass)) {
            return false;
        }
        //找到 地址
        $className = $supportedClass[$type];
        //返回一个新的实例类
        return $needInstance ? (new \ReflectionClass($className))->newInstanceArgs($params) : $className;
    }

}
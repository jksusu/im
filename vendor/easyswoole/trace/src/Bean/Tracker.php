<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/8/14
 * Time: 下午1:04
 */

namespace EasySwoole\Trace\Bean;


class Tracker
{
    private $attribute = [];
    private $pointStack = []; //调用点栈
    private $pointStackMap = [];
    private $trackerToken;

    function __construct($trackerToken)
    {
        $this->trackerToken = $trackerToken;
    }

    function getTrackerToken()
    {
        return $this->trackerToken;
    }

    /**
     * 设置追踪器标签
     * @param string|array $key
     * @param mixed $val
     * @return Tracker
     */
    function addAttribute($key, string $val = null): Tracker
    {
        $this->attribute[$key] = $val;
        return $this;
    }

    /**
     * 获取追踪器标签
     * @param string $key
     * @return mixed|null
     */
    function getAttribute($key)
    {
        if (isset($this->attribute[$key])) {
            return $this->attribute[$key];
        } else {
            return null;
        }
    }

    /**
     * 获取追踪器全部标签
     * @return array
     */
    function getAttributes(): array
    {
        return $this->attribute;
    }

    /**
     * 获取调用栈
     * @return array
     */
    function getPointStacks(): array
    {
        return $this->pointStack;
    }

    /**
     * 设置一个调用点
     */
    function setPoint(string $pointName, array $pointArgs = null, $pointCategory = 'default'): TrackerPoint
    {
        $t = new TrackerPoint($pointName, $pointArgs, $pointCategory);
        $this->pointStackMap[$pointName] = $t;
        array_push($this->pointStack, $t);
        return $t;
    }

    function endPoint(string $pointName,int $status = TrackerPoint::STATUS_SUCCESS,array $endArgs = [])
    {
        if(isset($this->pointStackMap[$pointName])){
            $t = $this->pointStackMap[$pointName];
            $t->endPoint( $status,$endArgs);
        }else{
            throw new \Exception("point : {$pointName} is not exist");
        }
    }

    /**
     * 转为字符串
     * @return string
     */
    function __toString()
    {
        // TODO: Implement __toString() method.
        $msg = "TrackerToken:{$this->trackerToken}\n";
        foreach ($this->attribute as $key => $value) {
            $msg .= "Attribute@{$key}:\n{$value}\n";
        }
        $msg .= $this->stackToString($this->pointStack);
        return $msg;
    }

    /**
     * 按分类转为字符串
     * @param null|string $category
     * @return string
     */
    function toString($category = null)
    {
        if ($category) {
            $msg = '';
            foreach ($this->attribute as $key => $value) {
                $msg .= "Attribute@{$key}:\n{$value}\n";
            }
            $list = [];
            // 支持传入数组获取多个分类
            foreach ($this->pointStack as $item) {
                if (is_array($category) && in_array($item->getPointCategory(), $category)) {
                    array_push($list, $item);
                } else if ($item->getPointCategory() == $category) {
                    array_push($list, $item);
                }
            }
            $msg .= $this->stackToString($list);
            return $msg;
        } else {
            return $this->__toString();
        }
    }

    /**
     * 调用栈转为字符串
     * @param array $stack
     * @return string
     * @author: eValor < master@evalor.cn >
     */
    private function stackToString(array $stack)
    {
        $msg = "Stack:\n";
        foreach ($stack as $item) {
            $msg .= "\t" . (string)$item . "\n";
        }
        return $msg;
    }
}

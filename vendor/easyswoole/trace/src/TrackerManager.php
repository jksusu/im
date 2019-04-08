<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/8/14
 * Time: 下午1:03
 */

namespace EasySwoole\Trace;

use EasySwoole\Trace\Bean\Tracker as TrackerBean;

class TrackerManager
{
    private $tokenGenerator;
    private $endTrackerHook;
    private $stack = [];


    function setEndTrackerHook(callable $hook):TrackerManager
    {
        $this->endTrackerHook = $hook;
        return $this;
    }

    function setTokenGenerator(callable $tokenGenerator):TrackerManager
    {
        $this->tokenGenerator = $tokenGenerator;
        return $this;
    }

    /**
     * @param null $token
     * @throws \Exception
     * @return TrackerBean
     */
    function getTracker($token = null):TrackerBean
    {
        $token = $this->token($token);
        if(!isset($this->stack[$token])){
            $this->stack[$token] = new TrackerBean($token);
        }
        return $this->stack[$token];
    }

    /**
     * @param null $token
     * @throws \Exception
     * @return TrackerBean
     */
    function removeTracker($token = null):?TrackerBean
    {
        $token = $this->token($token);
        if(isset($this->stack[$token])){
            $t =  $this->stack[$token];
            unset($this->stack[$token]);
            return $t;
        }else{
            return null;
        }
    }

    /**
     * @param null $token
     * @throws \Exception
     * @return TrackerBean
     */
    function closeTracker($token = null):?TrackerBean
    {
        $token = $this->token($token);
        if(isset($this->stack[$token])){
            $tracker = $this->stack[$token];
            if(is_callable($this->endTrackerHook)){
                call_user_func($this->endTrackerHook,$token,$tracker);
            }
            unset($this->stack[$token]);
            return $tracker;
        }else{
            return null;
        }
    }

    function clear():TrackerManager
    {
        $this->stack = [];
        return $this;
    }

    function getTrackerStack():array
    {
        return $this->stack;
    }

    private function token($token)
    {
        if($token === null){
            if(is_callable($this->tokenGenerator)){
                $token = call_user_func($this->tokenGenerator);
            }else{
                throw new \Exception('tokenGenerator is not set');
            }
        }
        return $token;
    }
}
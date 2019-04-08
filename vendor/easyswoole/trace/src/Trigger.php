<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/8/14
 * Time: 下午12:51
 */

namespace EasySwoole\Trace;


use EasySwoole\Trace\AbstractInterface\LoggerInterface;
use EasySwoole\Trace\AbstractInterface\TriggerInterface;
use EasySwoole\Trace\Bean\Error;
use EasySwoole\Trace\Bean\Location;

class Trigger implements TriggerInterface
{
    protected $logger;
    protected $displayError;

    function __construct(LoggerInterface $logger,$displayError = true)
    {
        $this->logger = $logger;
        $this->displayError = $displayError;
    }

    public function error($msg, int $errorCode = E_USER_ERROR, Location $location = null)
    {
        // TODO: Implement error() method.
        if($location == null){
            $location = new Location();
            $debugTrace = debug_backtrace();
            $caller = array_shift($debugTrace);
            $location->setLine($caller['line']);
            $location->setFile($caller['file']);
        }
        $error = Error::mapErrorCode($errorCode);
        $msg = "[file:{$location->getFile()}][line:{$location->getLine()}]{$msg}";
        $this->logger->log($msg,$error->getErrorType());
        if($this->displayError){
            $this->logger->console($msg,$error->getErrorType(),false);
        }
    }

    public function throwable(\Throwable $throwable)
    {
        // TODO: Implement throwable() method.
        $msg = "[file:{$throwable->getFile()}][line:{$throwable->getLine()}]{$throwable->getMessage()}";
        $this->logger->log($msg,'Exception');
        if($this->displayError){
            $this->logger->console($msg,'Exception',false);
        }
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2019-01-11
 * Time: 23:24
 */

namespace EasySwoole\Trace\Bean;


class Error
{
    protected $logType;
    protected $errorType;

    /**
     * @return mixed
     */
    public function getLogType():?int
    {
        return $this->logType;
    }

    /**
     * @param mixed $logType
     */
    public function setLogType($logType): void
    {
        $this->logType = $logType;
    }

    /**
     * @return mixed
     */
    public function getErrorType():?string
    {
        return $this->errorType;
    }

    /**
     * @param mixed $errorType
     */
    public function setErrorType($errorType): void
    {
        $this->errorType = $errorType;
    }

    public static function mapErrorCode(int $code):Error
    {
        $error = $log = null;
        switch ($code) {
            case E_PARSE:
            case E_ERROR:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_USER_ERROR:
                $error = 'FatalError';
                $log = LOG_ERR;
                break;
            case E_WARNING:
            case E_USER_WARNING:
            case E_COMPILE_WARNING:
            case E_RECOVERABLE_ERROR:
                $error = 'Warning';
                $log = LOG_WARNING;
                break;
            case E_NOTICE:
            case E_USER_NOTICE:
                $error = 'Notice';
                $log = LOG_NOTICE;
                break;
            case E_STRICT:
                $error = 'Strict';
                $log = LOG_NOTICE;
                break;
            case E_DEPRECATED:
            case E_USER_DEPRECATED:
                $error = 'Deprecated';
                $log = LOG_NOTICE;
                break;
            default :
                break;
        }
        $return = new Error();
        $return->setErrorType($error);
        $return->setLogType($log);
        return $return;
    }
}
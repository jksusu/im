<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/8/14
 * Time: 下午1:04
 */

namespace EasySwoole\Trace\Bean;


class TrackerPoint
{
    const STATUS_SUCCESS = 1;
    const STATUS_FAIL = 0;
    const STATUS_NOT_END = -1;

    private $pointName;
    private $pointStartTime;
    private $pointEndTime;
    private $pointStatus = self::STATUS_NOT_END;
    private $pointEndArgs = [];
    private $pointStartArgs = [];
    private $pointCategory;
    private $pointFile;
    private $pointLine;

    private $hasEnd = 0;
    private $pointTakeTime = -1;

    final function __construct(string $name,$args,$category)
    {
        $trace = debug_backtrace();
        $this->pointFile = $trace[1]['file'];
        $this->pointLine = $trace[1]['line'];
        $this->pointName = $name;
        $this->pointStartTime = microtime(true);
        $this->pointStartArgs = $args;
        $this->pointCategory = $category;
    }

    function endPoint(int $status = self::STATUS_SUCCESS,array $endArg = [])
    {
        if($this->hasEnd){
            throw new \Exception("tracker point :{$this->pointName} has end");
        }
        $this->pointStatus = $status;
        $this->pointEndTime = microtime(true);
        $this->pointEndArgs = $endArg;
        $t = round($this->pointEndTime - $this->pointStartTime,4);
        if($t > 1000000){
            $t = -1;
        }
        $this->pointTakeTime = $t;
    }

    /**
     * @return string
     */
    public function getPointName(): string
    {
        return $this->pointName;
    }

    /**
     * @return mixed
     */
    public function getPointStartTime()
    {
        return $this->pointStartTime;
    }

    /**
     * @return mixed
     */
    public function getPointEndTime()
    {
        return $this->pointEndTime;
    }

    /**
     * @return int
     */
    public function getPointStatus(): int
    {
        return $this->pointStatus;
    }

    /**
     * @return mixed
     */
    public function getPointEndArgs()
    {
        return $this->pointEndArgs;
    }

    public function getPointStartArgs()
    {
        return $this->pointStartArgs;
    }

    /**
     * @return mixed
     */
    public function getPointCategory()
    {
        return $this->pointCategory;
    }

    /**
     * @return mixed
     */
    public function getPointFile()
    {
        return $this->pointFile;
    }

    /**
     * @return mixed
     */
    public function getPointLine()
    {
        return $this->pointLine;
    }

    function __toString()
    {
        // TODO: Implement __toString() method.
        $status = null;
        switch ($this->pointStatus){
            case self::STATUS_SUCCESS:{
                $status = 'SUCCESS';
                break;
            }
            case self::STATUS_FAIL:{
                $status = 'FAIL';
                break;
            }
            default:{
                $status = 'NOT_END';
                break;
            }
        }
        return
"#:
\tpointName:{$this->pointName}
\tpointCategory:{$this->pointCategory}
\tpointStatus:{$status}
\tpointStartTime:{$this->pointStartTime}
\tpointTakeTime:{$this->pointTakeTime}
\tpointFile:{$this->pointFile}
\tpointLine:{$this->pointLine}
\tpointStartArgs:".json_encode($this->pointStartArgs,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES)."
\tpointEndArgs:".json_encode($this->pointEndArgs,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES)."\n";
    }
}
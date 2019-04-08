调试器组件 (可选组件)
============

扩展框架的调试能力，支持在各个方法处埋点，获得请求完整的调用链信息，方便排查调试

```php


$t = new \EasySwoole\Trace\TrackerManager();

$tracker = $t->getTracker('test');

$tracker->addAttribute('userName','用户1');
$tracker->addAttribute('userToken','userToken');

//sql one
$tracker->setPoint('查询用户余额',[
    'sql'=>'sql statement one'
]);
//模拟sql one执行
//$mode->func();
usleep(3000);
$tracker->endPoint('查询用户余额');

//curl api
$point = $tracker->setPoint('消息api查询',[
    'curlParamOne'=>time()
]);
//模拟curl执行 timeout
//$mode->func();
sleep(1);
$point->endPoint($point::STATUS_FAIL,[
    'curlResult'=>null,
    'msg'=>'超时'
]);

echo $tracker->toString();
```
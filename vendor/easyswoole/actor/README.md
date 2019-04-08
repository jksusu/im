# Actor
提供Actor模式支持，助力游戏行业开发。EasySwoole的Actor采用自定义process作为存储载体，以协程作为最小调度单位，利用协程Channel做mail box,而客户端与process之间的通讯，采用UnixSocket实现。

## 测试代码
### 服务端-SwooleServer模式
```
use EasySwoole\Actor\Actor;
use EasySwoole\Actor\Test\RoomActor;

Actor::getInstance()->register(RoomActor::class);


$http = new swoole_http_server("127.0.0.1", 9501);

Actor::getInstance()->attachToServer($http);

$http->on("start", function ($server) {
    echo "Swoole http server is started at http://127.0.0.1:9501\n";
});

$http->on("request", function ($request, $response) {
    var_dump(RoomActor::invoke()->status());
    $response->header("Content-Type", "text/plain");
    $response->end("Hello World\n");
});

$http->start();
```

### 服务端-Process模式
```
use EasySwoole\Actor\Actor;
use EasySwoole\Actor\Test\RoomActor;

Actor::getInstance()->register(RoomActor::class);


$processes = Actor::getInstance()->initProcess();

foreach ($processes as $process){
    $process->getProcess()->start();
}

while($ret = \Swoole\Process::wait()) {
    echo "PID={$ret['pid']}\n";
}
```

### 客户端-cli单元测试
```
use EasySwoole\Actor\Actor;
use EasySwoole\Actor\Test\RoomActor;

//模拟注册Actor ,若在整个easySwoole服务中，客户端不必重复注册，因为已经在全局事件中注册了
Actor::getInstance()->register(RoomActor::class);

go(function (){

    $actorId = RoomActor::invoke()->create([
        'arg'=>1,
        'time'=>time()
    ]);

    var_dump($actorId .' create');

    //单独退出某个actor
//    $ret = RoomActor::invoke()->exit('0000000000001');
    //单独推送给某个actor
//    $ret = RoomActor::invoke()->push('0020000000001',2);
    //单独推送给全部actor
//    $ret = RoomActor::invoke()->pushMulti([
//        "0020000000001"=>'0001data',
//        '0010000000001'=>'0022Data'
//    ]);
    //广播给全部actor
    $ret = RoomActor::invoke()->broadcastPush('121212');
    //退出全部actor
//    $ret = RoomActor::invoke()->exitAll();
     var_dump($ret);
});
```

### CLI独立测试Actor逻辑
```
use EasySwoole\Actor\Test\RoomActor;
use EasySwoole\Actor\DeveloperTool;

go(function (){
    $tool = new DeveloperTool(RoomActor::class,'001000001',[
        'startArg'=>'startArg....'
    ]);
    $tool->onReply(function ($data){
        var_dump('reply :'.$data);
    });
    swoole_event_add(STDIN,function ()use($tool){
        $ret = trim(fgets(STDIN));
        if(!empty($ret)){
            go(function ()use($tool,$ret){
                $tool->push(trim($ret));
            });
        }
    });
    $tool->run();
});
```

> 注意请基于协程实现，不要在actor中写阻塞代码，否则效率会非常差。其次使用虚拟机,docker等方式开发,不能在共享文件夹使用，因为unixsock 无法在共享目录中正确读写，请修改tempDir临时目录，把unxisock文件挂载在非共享目录即可.

## 内存问题
Actor数据分散在进程内，一个进程可能需要占用很大的内存，因此请根据实际业务量配置内存大小。
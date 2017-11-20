<?php

namespace app\push\controller;

use think\worker\Server;
use Workerman\Lib\Timer;

class WorkerController extends Server
{
    protected $socket = 'websocket://localhost:2346';

    /**
     * 收到信息
     * @param $connection
     * @param $data
     */
    public function onMessage($connection, $data)
    {
        // 给connection临时设置一个lastMessageTime属性，用来记录上次收到消息的时间
        $connection->lastMessageTime = time();
        $connection->send(json_encode($data));
        $connection->send('我收到你的信息了');
    }

    /**
     * 当连接建立时触发的回调函数
     * @param $connection
     */
    public function onConnect($connection)
    {
        echo $connection->getRemoteIP()."\n";
    }

    /**
     * 当连接断开时触发的回调函数
     * @param $connection
     */
    public function onClose($connection)
    {
        echo "ID:$connection->id ".iconv('UTF-8', 'gb2312', '链接被断') . "\n";
    }

    /**
     * 当客户端的连接上发生错误时触发
     * @param $connection
     * @param $code
     * @param $msg
     */
    public function onError($connection, $code, $msg)
    {
        echo "error $code $msg\n";
    }

    /**
     * 每个进程启动
     * @param $worker
     */
    public function onWorkerStart($worker)
    {
        // 进程启动后设置一个每秒运行一次的定时器
        Timer::add(1, function ()use($worker){
            $time_now = time();
            foreach ($worker->connections as $connection) {
                $connection->send('我收到你的信息了');
                // 有可能该connection还没收到过消息，则lastMessageTime设置为当前时间
                if (empty($connection->lastMessageTime)) {
                    $connection->lastMessageTime = $time_now;
                    continue;
                }
                // 上次通讯时间间隔大于心跳间隔，则认为客户端已经下线，关闭连接
                if ($time_now - $connection->lastMessageTime > 10) {
                    echo iconv("UTF-8", "gb2312", '连接超时断开.')."\n";
                    $connection->close();
                }
            }
        });
        echo $worker->id;
    }

}

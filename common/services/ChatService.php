<?php

namespace common\services;

use common\models\User;
use Workerman\Connection\TcpConnection;
use Workerman\Worker;
use yii\base\BaseObject;

class ChatService extends BaseObject
{
    private static $_users = [];
    /** @var  Worker $worker */
    private static $_worker;

    public static function setWorker(Worker $worker){
        static::$_worker = $worker;
    }

    public static function handleConnect(TcpConnection $connection)
    {
        $connection->onWebSocketConnect = function (TcpConnection $connection, $http_header) {
            // 可以在这里判断连接来源是否合法，不合法就关掉连接
            // $_SERVER['HTTP_ORIGIN']标识来自哪个站点的页面发起的websocket连接
//            if($_SERVER['HTTP_ORIGIN'] != 'http://chat.workerman.net')
//            {
//                $connection->close();
//            }
            // onWebSocketConnect 里面$_GET $_SERVER是可用的
            //var_dump($_GET, $_SERVER);
            //var_dump($connection, $http_header);
            $connection->send(json_encode(["type" => 1, "msg" => '连接成功 id:' . $connection->id]));

            $key = $_GET['key'] ?? '';
            $user = User::findByAuthKey($key);
            if (empty($user)) {
                $connection->close();
                return false;
            }

            static::$_users[$connection->id] = $user;

            return $connection->send(json_encode(["type" => 1, "msg" => '欢迎"' . $user->username . '"加入聊天👏']));
        };
    }

    public static function handleMessage(TcpConnection $connection, $data)
    {
        $currentId = $connection->id;
        $currentUser = static::$_users[$currentId];
        $connection->send(json_encode(["type" => 2, "msg" => $currentUser->username . ': ' . $data]));
        foreach (static::$_worker->connections as $connection){
            if($currentId == $connection->id){
                continue;
            }
            $connection->send(json_encode(["type" => 3, "msg" => $currentUser->username . ': ' . $data]));
        }
    }
}
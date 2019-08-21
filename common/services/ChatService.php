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

    public static function setWorker(Worker $worker)
    {
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
            static::pushMessage(["type" => 1, "msg" => '连接成功', 'id' => $connection->id], $connection);

            $key = $_GET['key'] ?? '';
            $user = User::findByAuthKey($key);
            if (empty($user)) {
                $connection->close();
                return false;
            }

            static::$_users[$connection->id] = $user;
            foreach (static::$_worker->connections as $connection) {
                static::pushMessage(["type" => 1, "msg" => '欢迎"' . $user->username . '"加入聊天👏'], $connection);
            }
        };
    }

    public static function handleMessage(TcpConnection $connection, $data)
    {
        $currentId = $connection->id;
        $currentUser = static::$_users[$currentId];
        static::pushMessage(["type" => 2, "msg" => $currentUser->username . ': ' . $data], $connection);
        foreach (static::$_worker->connections as $connection) {
            if ($currentId == $connection->id) {
                continue;
            }
            static::pushMessage(["type" => 3, "msg" => $currentUser->username . ': ' . $data], $connection);
        }
    }

    public static function handleClose($connection)
    {
        $user = static::$_users[$connection->id];
        unset(static::$_users[$connection->id]);
        foreach (static::$_worker->connections as $connection) {
            static::pushMessage(["type" => 1, "msg" => '"' . $user->username . '"已下线'], $connection);
        }
    }

    protected static function pushMessage(array $msg, TcpConnection $connection)
    {
        return $connection->send(json_encode($msg));
    }
}
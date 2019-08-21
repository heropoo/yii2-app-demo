<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/common/config/bootstrap.php';
require __DIR__ . '/console/config/bootstrap.php';

use common\services\ChatService;
use Workerman\Connection\TcpConnection;
use Workerman\Worker;
use yii\console\Application;
use yii\helpers\ArrayHelper;

$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/common/config/main.php',
    require __DIR__ . '/common/config/main-local.php',
    require __DIR__ . '/console/config/main.php',
    require __DIR__ . '/console/config/main-local.php'
);

$application = new yii\console\Application($config);


// Create a Websocket server
$worker = new Worker("websocket://0.0.0.0:2346");

// 4 processes
$worker->count = 4;

$worker->onWorkerStart = function($worker){
    ChatService::setWorker($worker);
};

// Emitted when new connection come
$worker->onConnect = function (TcpConnection $connection) {
    echo "New connection: ".$connection->id."\n";
    //$connection->send('你好 '.$connection->id);
    ChatService::handleConnect($connection);
};

//Emitted when data received
$worker->onMessage = function (TcpConnection $connection, $data){
//    $connection->send('你：' . $data);
    ChatService::handleMessage($connection, $data);
};

// Emitted when connection closed
$worker->onClose = function (TcpConnection $connection) {
    echo "Connection closed\n";
    ChatService::handleClose($connection);
};

// Run worker
Worker::runAll();
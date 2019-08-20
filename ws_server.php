<?php
require_once __DIR__.'/vendor/autoload.php';

use Workerman\Connection\TcpConnection;
use Workerman\Worker;

// Create a Websocket server
$worker = new Worker("websocket://0.0.0.0:2346");

// 4 processes
$worker->count = 4;

// Emitted when new connection come
$worker->onConnect = function (TcpConnection $connection) {
    echo "New connection: ".$connection->id."\n";
    $connection->send('你好 '.$connection->id);
};

//Emitted when data received
$worker->onMessage = function (TcpConnection $connection, $data) {
    $connection->send('你：' . $data);
};

// Emitted when connection closed
$worker->onClose = function (TcpConnection $connection) {
    echo "Connection closed\n";
};

// Run worker
Worker::runAll();
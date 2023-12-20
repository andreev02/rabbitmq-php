<?php

require_once __DIR__.'\..\vendor\autoload.php';
    
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$exchange = 'router';
$queue = 'msgs';

$connection = new AMQPStreamConnection("localhost", "5672", "guest", "guest");
$channel = $connection->channel();

$channel->queue_declare($queue, false, true, false, false);

$channel->exchange_declare($exchange, 'direct', false, true, false);

$channel->queue_bind($queue, $exchange);

$message = new AMQPMessage("Hello world with help of rabbitMQ");
$channel->basic_publish($message, $exchange);

echo "[!] Message sended!";

$channel->close();
$connection->close();
<?php
/**
 * unix域套接字-进程间通信
 * 
 * server[create bind listen receive]
 * client[create connect send close]
 */

namespace unix_socket;

use Swoole\Process;


define('SOCKET_PATH', realpath(__DIR__) . '/unix.sock');
define('MESSAGE_LENGTH', 1024);


// 创建server进程
$server_process = new Process(function() {
    // create, bind, listen, receive
    // create
    $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

    // bind
    socket_bind($socket, SOCKET_PATH);

    // listen
    socket_listen($socket);

    // receive
    while ($message_socket = socket_accept($socket)) {
        socket_recv($message_socket, $message, MESSAGE_LENGTH, MSG_OOB);
    }
});


// 创建client进程
$client_process = new Process(function() {
    sleep(1);

    // create connect send close
    $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

    // connect
    socket_connect($socket, SOCKET_PATH);

    // send
    socket_send($socket, 'hello world, time:' . date('Y-m-d H:i:s'), MESSAGE_LENGTH, MSG_OOB);

    // close
    socket_close($socket);
});


// 子进程唤醒就绪
$server_process->start();
$client_process->start();

// 主进程退出
Process::wait(true);
echo 'main process finisned.';








































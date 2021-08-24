<?php

/**
 * 演示udp server
 *
 * create bind recvfrom sendto
 *
 * @see https://blog.csdn.net/weixin_35838504/article/details/81160869
 */

define('SERVER_IP', '127.0.0.1');
define('SERVER_PORT', 8002);

$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
if (false === $socket) {
    log_error('socket create failed.');
}

$ok = socket_bind($socket, SERVER_IP, SERVER_PORT);
if (!$ok) {
    log_error('socket bind failed.');
}

while (true) {
    log_info('wait for message...');

    // receive
    socket_recvfrom($socket, $buf, 512, 0, $remote_ip, $remote_port);
    log_info("$remote_ip:$remote_port data:[$buf]");

    // send_back
    $response = "ok,$buf";
    $length = socket_sendto($socket, $response, strlen($response), 0, $remote_ip, $remote_port);
    log_info("send message back, length:$length");
}

socket_close($socket);


function log_error($msg = '') {
    $error_code = socket_last_error();
    $error_msg = socket_strerror($error_code);

    die("error, code:[$error_code] msg:[$error_msg] info:[$msg]");
}

function log_info($msg) {
    echo $msg . PHP_EOL;
}










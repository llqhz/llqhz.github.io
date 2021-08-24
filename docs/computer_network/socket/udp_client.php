<?php


define('SERVER_IP', '127.0.0.1');
define('SERVER_PORT', 8002);


$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
if (false === $socket) {
    log_error('create socket failed.');
}

echo "please message to send: ";
$input = rtrim(fgets(STDIN));

$length = socket_sendto($socket, $input, strlen($input), 0, SERVER_IP, SERVER_PORT);

log_info("send message length: $length");


// receive
socket_recvfrom($socket, $buf, 512, 0, $remote_ip, $remote_port);
log_info("$remote_ip:$remote_port data:[$buf]");


socket_close($socket);



function log_error($msg = '') {
    $error_code = socket_last_error();
    $error_msg = socket_strerror($error_code);

    die("error, code:[$error_code] msg:[$error_msg] info:[$msg]");
}

function log_info($msg) {
    echo $msg . PHP_EOL;
}


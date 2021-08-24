<?php

/**
 * Class Client
 *
 * @author llqhz@qq.com
 */
class Client
{
    public const IP = '127.0.0.1';
    public const PORT = 8003;

    public const BUFF_STR_LEN = 512;

    protected $socket;

    public static function main()
    {
        $client = new self();

        $client->create();

        $client->connect();

        $client->send();

        $client->recv();

        $client->close();
    }

    public function create()
    {
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if (!$socket) {
            self::error('create socket failed.');
        }
        $this->socket = $socket;
    }

    public function connect()
    {
        $ok = socket_connect($this->socket, self::IP, self::PORT);
        if (!$ok) {
            self::error('connect socket failed.');
        }
    }

    public function send()
    {
        self::info('---------------  send start  --------------- ');
        $message = rtrim(fgets(STDIN));

        $msg_len = strlen($message);
        $sent = 0;
        while (0 < $left = ($msg_len - $sent)) {
            $buf = substr($message, $sent, self::BUFF_STR_LEN);
            self::info('send item start, info:' . json_encode([$buf]));
            $sent_item = socket_send($this->socket, $buf, strlen($buf), 0);
            self::info('send item end, info:'. json_encode([$sent_item, $buf]));
            if ($sent_item === false) {
                break;
            }
            $sent += $sent_item;
        }
        return $sent;
    }

    public function recv()
    {
        self::info('receive from server:');
        $total_len = 0;
        $message = '';
        do {
            $recv_len = socket_recv($this->socket, $buf, self::BUFF_STR_LEN, 0);
            if ($recv_len === false) {
                break;
            }
            $message .= $buf;
            $total_len += $recv_len;
        } while ($recv_len == self::BUFF_STR_LEN);

        self::info(sprintf("response:[%s], response_len:[%d]", $message, strlen($message)));
        return $message;
    }

    public function close()
    {
        socket_close($this->socket);
    }


    public static function error($msg)
    {
        $error_code = socket_last_error();
        $error_msg = socket_strerror($error_code);

        die("error, code:[$error_code] msg:[$error_msg] info:[$msg]" . PHP_EOL);
    }

    public static function info($msg)
    {
        echo $msg . PHP_EOL;
    }
}


Client::main();


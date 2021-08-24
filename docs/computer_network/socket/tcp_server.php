<?php

/**
 * Class Client
 *
 * @author llqhz@qq.com
 */
class Server
{
    public const IP = '127.0.0.1';
    public const PORT = 8003;

    public const BUFF_STR_LEN = 512;

    /**
     * 缓冲队列
     */
    public const BACK_LOG = 14;

    protected $socket;

    public static function main()
    {
        $server = new self();

        $server->create();

        $server->bind();

        $server->listen();

        while (true) {
            $socket = $server->accept();

            $request = $server->recv($socket);

            $response = $server->getResponse($request);

            $server->send($socket, $response);

            $server->close($socket);
        }
    }


    public function create()
    {
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if (!$socket) {
            self::error('create socket failed.');
        }
        $this->socket = $socket;
    }

    public function bind()
    {
        $ok = socket_bind($this->socket, self::IP, self::PORT);
        if (!$ok) {
            self::error('bind socket failed.');
        }
    }

    public function listen()
    {
        $ok = socket_listen($this->socket, self::BACK_LOG);
        if (!$ok) {
            self::error('listen socket failed.');
        }
    }

    public function accept()
    {
        self::info('wait for accept a new client.');
        $socket_accept = socket_accept($this->socket);

        socket_getpeername($socket_accept, $addr, $port);

        self::info("accept a new client, ip:[$addr], port:[$port]");
        return $socket_accept;
    }

    public function recv($socket)
    {
        self::info('---------- receive start ----------');
        $message = '';
        do {
            self::info('receive item start.');
            $recv_len = socket_recv($socket, $buf, self::BUFF_STR_LEN, 0);
            self::info('receive item end.');
            if ($recv_len === false || $recv_len === 0) {
                break;
            }
            $message .= $buf;
        } while ($recv_len == self::BUFF_STR_LEN);
        self::info('---------- receive end ----------');
        return $message;
    }

    public function getResponse($request)
    {
        self::info("-------- request --------\n$request\n-------- request end --------");

        return "hello, client!";
    }

    public function send($socket, $response)
    {
        self::info('send start.');
        $response_len = strlen($response);
        $sent = 0;
        while (0 < $left = ($response_len - $sent)) {
            $buf = substr($response, $sent, self::BUFF_STR_LEN);
            $sent += socket_send($socket, $buf, strlen($buf), 0);
        }
        self::info("response:[$response], res_len:[$response_len], sent:[$sent]");
        return $sent === $response_len;
    }

    public function close($socket)
    {
        socket_close($socket);
    }

    public static function error($msg)
    {
        $error_code = socket_last_error();
        $error_msg = socket_strerror($error_code);

        die("error, code:[$error_code] msg:[$error_msg] info:[$msg]");
    }

    public static function info($msg)
    {
        echo $msg . PHP_EOL;
    }
}



Server::main();







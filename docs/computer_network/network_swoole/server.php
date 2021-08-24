<?php

class Server
{
    protected $socket;

    const IP = '192.168.31.66';
    const PORT = '8888';

    const RECV_BUF_LEN = 65535;

    public static function main()
    {
        $server = new Server();

        $server->create();

        $server->bind();

        $server->setOptions();

        $server->loopServe();
    }

    protected function create()
    {
        $socket = socket_create(AF_INET, SOCK_RAW, IPPROTO_IP);
        if (!$socket) {
            self::error('create socket failed.');
        }
        $this->socket = $socket;
    }

    public function bind()
    {
        $ok = socket_bind($this->socket, self::IP, 8888);
        if (!$ok) {
            self::error('bind socket failed.');
        }
    }

    public function setOptions()
    {

    }

    public function loopServe()
    {
        while (true) {
            socket_recvfrom($this->socket, $buf, self::RECV_BUF_LEN, 0, $remote_ip, $remote_port);
            var_dump([
                $buf,
                $remote_ip,
                $remote_port
            ]);
        }
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

<?php

/**
 *
 * PipLine 与 事务
 */


abstract class Base
{
    protected $redis;

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('127.0.0.1', 6379);
    }

    public function __destruct()
    {
        $this->redis->close();
    }

    abstract public function request();
}

class PipLine extends Base
{

    public function request()
    {
        $redis = $this->redis;

        $redis->multi(Redis::PIPELINE);

        $v1 = $redis->get('k1');
        $v2 = $redis->get('k2');
        $user_info = $redis->hMGet('user:1:info', ['id', 'name', 'age']);

        $res = $redis->exec();

        var_dump(compact('v1', 'v2', 'user_info', 'res'));
    }
}


class Transaction extends Base
{

    public function request()
    {
        $redis = $this->redis;

        $redis->multi(Redis::MULTI);

        $v1 = $redis->get('k1');
        $v2 = $redis->get('k2');
        $user_info = $redis->hMGet('user:1:info', ['id', 'name', 'age']);

        $res = $redis->exec();

        // res 是每条命令的结果list[]
        var_dump(compact('v1', 'v2', 'user_info', 'res'));

        /*
         * array(4) {
              ["v1"]=>
                object(Redis)#4 (0) {
              }
              ["v2"]=>
                object(Redis)#4 (0) {
              }
              ["user_info"]=>
                object(Redis)#4 (0) {
              }
              ["res"] =>
                  array(3) {
                    [0]=>
                        string(7) "40hello"
                    [1]=>
                        bool(false)
                    [2]=>
                        array(3) {
                          ["id"]=>
                            string(1) "1"
                          ["name"]=>
                            string(1) "a"
                          ["age"]=>
                            string(2) "10"
                       }
                 }
            }
         *
         */
    }
}


class Client
{
    public static function main()
    {
        $pip_line = new PipLine();
        $pip_line->request();

        $transaction = new Transaction();
        $transaction->request();
    }
}

Client::main();






























































































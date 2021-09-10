<?php

/**
 * 发布订阅
 *
 * subscribe channel-1 channel-2
 * publish channel-1 hello
 *
 * usage1: php ./12.php producer
 * usage2: php ./12.php
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
}


class Consumer extends Base
{
    protected $id;

    public function __construct($id)
    {
        parent::__construct();
        $this->id = $id;

        // 设置订阅着等待时间不超时
        $this->redis->setOption(Redis::OPT_READ_TIMEOUT, -1);
    }
    
    public function subscribe()
    {
        $id = $this->id;
        echo "consumer [$id] listen to channel...\n";
        $this->redis->subscribe(
            ['chan-1', 'chan-2', 'chan-3'],
            function ($redis, $channel, $message) use ($id) {
                echo "channel:[$channel] consumer [$id] get message: [$message]\n";
            }
        );
    }
}


class Producer extends Base
{
    public function publish()
    {
        $this->redis->publish('chan-1', 'hello');
        $this->redis->publish('chan-2', 'world');
        $this->redis->publish('chan-3', 'php');
    }
}


class Client
{
    public static function main($argc, $argv)
    {
        $is_producer = isset($argv[1]) && $argv[1] == 'producer';

        if (!$is_producer) {
            $consumer = new Consumer(1);
            $consumer->subscribe();
        }

        for ($i = 0; $i < 100; $i++) {
            $producer = new Producer();
            $producer->publish();
            sleep(1);
        }
    }
}


Client::main($argc, $argv);






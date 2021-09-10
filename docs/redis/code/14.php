<?php

/**
 * hyperLogLog
 * 基数计数估算
 *
 * pfAdd  => pfCount
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

class HyperLogLog extends Base
{
    const HYPER_LOG_KEY_1 = 'hyper_log_count:1';
    const HYPER_LOG_KEY_2 = 'hyper_log_count:2';
    const HYPER_LOG_KEY_3 = 'hyper_log_count:3';
    const HYPER_LOG_KEY_4 = 'hyper_log_count:4';
    const HYPER_LOG_KEY_5 = 'hyper_log_count:5';

    const HYPER_LOG_KEYS = [
        self::HYPER_LOG_KEY_1,
        self::HYPER_LOG_KEY_2,
        self::HYPER_LOG_KEY_3,
        self::HYPER_LOG_KEY_4,
        self::HYPER_LOG_KEY_5,
    ];

    public function __construct()
    {
        parent::__construct();

        $this->initElements();
    }

    protected function initElements()
    {
        $this->redis->pfAdd(self::HYPER_LOG_KEY_1, range(0, 10000));
        $this->redis->pfAdd(self::HYPER_LOG_KEY_2, range(10000, 20000));
        $this->redis->pfAdd(self::HYPER_LOG_KEY_3, range(15000, 30000));
        $this->redis->pfAdd(self::HYPER_LOG_KEY_4, range(25000, 40000));
        $this->redis->pfAdd(self::HYPER_LOG_KEY_5, range(27000, 50000));
    }

    public function addElement($element)
    {
        return $this->redis->pfAdd(self::HYPER_LOG_KEY_1, [$element]);
    }

    public function countOne()
    {
        return $this->redis->pfCount(self::HYPER_LOG_KEY_1);
    }
    
    public function countAll()
    {
        return $this->redis->pfCount(self::HYPER_LOG_KEYS);
    }
}


class Client
{
    public static function main()
    {
        $hyper = new HyperLogLog();

        $hyper->addElement(1000001);
        $hyper->addElement(1000002);
        $hyper->addElement(1000003);

        $one = $hyper->countOne();
        $all = $hyper->countAll();
        var_dump(compact('one', 'all'));
    }
}

Client::main();
















































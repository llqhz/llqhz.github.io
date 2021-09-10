<?php


/**
 * 活跃用户统计
 *
 * setbit key id 1
 * bitcount key
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


class ActiveCounter extends Base
{
    protected static function getBitIndexFromUserId($user_id)
    {
        return intval($user_id) - 10000;
    }

    public function active($user_id)
    {
        $key = 'user_active_count:' . date('Ymd-His');
        $bit_index = self::getBitIndexFromUserId($user_id);
        $this->redis->setBit($key, $bit_index, 1);
    }

    public function count()
    {
        $key = 'user_active_count:' . date('Ymd-His');
        return $this->redis->bitCount($key);
    }

    public function countWeek()
    {
        $keys = [
            'user_active_count:' . date('Ymd-His'),
            'user_active_count:' . date('Ymd-His', strtotime('-1 days')),
            'user_active_count:' . date('Ymd-His', strtotime('-2 days')),
            'user_active_count:' . date('Ymd-His', strtotime('-3 days')),
            'user_active_count:' . date('Ymd-His', strtotime('-4 days')),
            'user_active_count:' . date('Ymd-His', strtotime('-5 days')),
            'user_active_count:' . date('Ymd-His', strtotime('-6 days')),
        ];

        // and or not xor
        $this->redis->bitOp('or', 'user_active_count_week', ...$keys);

        return $this->redis->bitCount('user_active_count_week');
    }

    public function isActive($user_id)
    {
        $key = 'user_active_count:' . date('Ymd-His');
        $bit_index = self::getBitIndexFromUserId($user_id);
        return $this->redis->getBit($key, $bit_index) == 1;
    }
}


class Client
{
    public static function main()
    {
        $counter = new ActiveCounter();

        $counter->active(10001);
        $counter->active(10101);
        $counter->active(10011);
        $counter->active(10201);
        $counter->active(10031);


        $active_count = $counter->count();

        $active_count_week = $counter->countWeek();
        var_dump($active_count, $active_count_week);
    }
}

Client::main();



























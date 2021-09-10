<?php

/**
 * 用户主页的访问量
 *
 * hincrby user:1 view_count
 */


class UserInfoViewCount
{
    protected $redis;

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('127.0.0.1', 6379);
    }

    public function view(int $user_id)
    {
        $key = "user:$user_id:info";
        return $this->redis->hIncrBy($key, 'view_count', 1);
    }

    public function __destruct()
    {
        $this->redis->close();
    }
}


class Client
{
    public static function main()
    {
        $view = new UserInfoViewCount();
        $num = $view->view(2);
        var_dump($num);
    }
}



Client::main();



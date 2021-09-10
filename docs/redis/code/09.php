<?php

/**
 * 共同关注好友
 * 集合sinter
 */


class User
{
    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('127.0.0.1', 6379);

        $this->initUser1();
        $this->initUser2();
    }

    public function __destruct()
    {
        $this->redis->close();
    }

    public function initUser1()
    {
        $key = 'user:10001:flowers';
        $this->redis->sAdd($key, ...range(10002, 10050));
    }

    public function initUser2()
    {
        $key = 'user:10002:flowers';
        $this->redis->sAdd($key, ...range(10040, 10100));
    }

    public function sInter()
    {
        $key1 = 'user:10001:flowers';
        $key2 = 'user:10002:flowers';

        return $this->redis->sInter($key1, $key2);
    }
}




class Client
{
    public static function main()
    {

        $user = new User();

        $users = $user->sInter();
        var_dump($users);
    }
}



Client::main();

























































































































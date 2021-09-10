<?php

/**
 * sRandMember 随机抽奖
 */


class Member
{
    public const PRIZE_MEMBERS = 'prize_members';

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('127.0.0.1', 6379);

        $this->redis->sAdd(self::PRIZE_MEMBERS, ...range(10000, 10100));
    }
    
    public function randoms(int $count = 10)
    {
        return $this->redis->sRandMember(self::PRIZE_MEMBERS, $count);
    }
}


class Client
{
    public static function main()
    {
        $member = new Member();
        $members = $member->randoms();
        var_dump($members);
    }
}


Client::main();
























































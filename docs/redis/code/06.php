<?php

/**
 * 微博动态实现 (list)
 * 新加微博, 更新到列表list, 查询
 * lpush lrange lrem
 */


class User
{
    public static $key;

    public function __construct(int $user_id)
    {
        $this->user_id = $user_id;
        self::$key = "user:{$this->user_id}:message_list";

        $this->redis = new Redis();
        $this->redis->connect('127.0.0.1', 6379);
    }

    public function addMessage(int $message_id)
    {
        return $this->redis->lPush(self::$key, $message_id);
    }
    
    public function getMessagesList()
    {
        return $this->redis->lRange(self::$key, 0, -1);
    }

    public function removeMessage(int $message_id)
    {
        return $this->redis->lRem(self::$key, $message_id, 1);
    }
}



class Client
{
    public static function main()
    {
        $user = new User(2);
        $user->addMessage(1001);
        $user->addMessage(1002);
        $user->addMessage(1003);
        $user->addMessage(1004);
        $user->addMessage(1005);

        $user->removeMessage(1004);

        $message_list = $user->getMessagesList();
        var_dump($message_list);
    }
}



Client::main();






































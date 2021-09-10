<?php

/**
 * 用户信息标签
 */

class Base
{
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


class User extends Base
{
    protected $user_id;

    public function __construct($user_id)
    {
        parent::__construct();

        $this->user_id = $user_id;
    }

    public function addTag($tag)
    {
        $key = "user:{$this->user_id}:tags";
        $this->redis->sAdd($key, $tag);
    }

    public function getTags()
    {
        $key = "user:{$this->user_id}:tags";
        return $this->redis->sMembers($key);
    }
}


class Tag extends Base
{
    protected $tag;

    public function __construct($tag)
    {
        parent::__construct();

        $this->tag = $tag;
    }

    public function addUser($user_id)
    {
        $key = "tag:{$this->tag}:sets";
        $this->redis->sAdd($key, $user_id);
    }

    public function getUsers()
    {
        $key = "tag:{$this->tag}:sets";
        return $this->redis->sMembers($key);
    }
}



class Client
{
    public static function main()
    {
        // 用户添加标签
        $user_id = 10002;
        $tag_id = 'python';


        $user = new User($user_id);
        $user->addTag($tag_id);

        $tag = new Tag($tag_id);
        $tag->addUser($user_id);

        $tags = $user->getTags();
        $users = $tag->getUsers();

        var_dump($tags, $users);

    }
}



Client::main();




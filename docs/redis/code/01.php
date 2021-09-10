<?php


/**
 * 用户访问页面次数计数
 *
 * 1. redis->incr(page_id)
 * 2. redis->incr(user_id:page_id)
 *
 * Class ViewCounter
 */
class ViewCounter
{
    protected $redis;

    public function __construct()
    {
        $redis = new Redis();
        $redis->connect('127.0.0.1', 6379);
        $this->redis = $redis;
    }

    public function __destruct()
    {
        $this->redis->close();
    }

    /**
     * 页面访问次数统计
     */
    public function incrPageCount($page_id)
    {
        $key = sprintf("page:%s", $page_id);
        $this->redis->incr($key);
    }
    
    /**
     * 用户访问页面次数统计
     */
    public function incrUserPageCount($user_id, $page_id)
    {
        $key = sprintf("user_page:%s:%s", $user_id, $page_id);
        $this->redis->incr($key);
    }

    public function getPageCount($page_id)
    {
        $key = sprintf("page:%s", $page_id);
        return $this->redis->get($key);
    }

    public function getUserPageCount($user_id, $page_id)
    {
        $key = sprintf("user_page:%s:%s", $user_id, $page_id);
        return $this->redis->get($key);
    }

    public static function main()
    {
        $view = new ViewCounter();

        $user_id = 1001;
        $page_id = 21;

        // 统计
        foreach (range(1, 100) as $num) {
            $view->incrPageCount($page_id);
            $view->incrUserPageCount($user_id, $page_id);
        }

        // 获取统计值
        $page_count = $view->getPageCount($page_id);
        $user_page_count = $view->getUserPageCount($user_id, $page_id);

        var_dump($page_count, $user_page_count);
    }
}


ViewCounter::main();


<?php

/**
 * 排行榜
 * 有序集合: zset
 *
 */


class Books
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

    public function likeBook($book_id, $user_id)
    {
        if ($this->isLiked($book_id, $user_id)) {
            return true;
        }

        # 书籍的粉丝集合加上用户
        $this->updateBookLikes($book_id, $user_id);

        # 书籍排行榜的该书籍+1
        $key = "book:rank";
        $this->redis->zIncrBy($key, 1, $book_id);
    }

    protected function isLiked($book_id, $user_id)
    {
        $key = "book:$book_id:like_users";
        return $this->redis->sIsMember($key, $user_id);
    }

    protected function updateBookLikes($book_id, $user_id)
    {
        $key = "book:$book_id:like_users";
        $this->redis->sAdd($key, $user_id);
    }

    /**
     * 获取排行榜
     */
    public function getBookRanks()
    {
        $key = "book:rank";
        return $this->redis->zRevRange($key, 0, -1, true);
    }
}



class Client
{
    public static function main()
    {
        $books = new Books();

        $book_id = 10004;
        $user_id = 10004;
        $books->likeBook($book_id, $user_id);

        $ranks = $books->getBookRanks();

        var_dump($ranks);

        /*
         * 书籍ID => 书籍名次
         * array(4) {
              [10001]=>
              float(2)
              [10004]=>
              float(1)
              [10003]=>
              float(1)
              [10002]=>
              float(1)
            }
         */
    }
}

Client::main();






























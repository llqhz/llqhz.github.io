<?php


/**
 * 用hash缓存key
 *
 * hMGet -> query -> hMSet
 *
 * user:1 => { id, name, age, addr }
 */

class UserInfoFacade
{
    public $mysql_user_info;
    public $redis_user_info;

    public function __construct()
    {
        $this->mysql_user_info = new MySQLUserInfo();
        $this->redis_user_info = new RedisUserInfo();
    }

    public function getUserInfo(int $user_id)
    {
        $user_info = $this->redis_user_info->getFromCache($user_id);
        if (!$user_info) {
            $user_info = $this->mysql_user_info->query($user_id);

            if ($user_info) {
                $this->redis_user_info->setToCache($user_id, $user_info);
            }
        }
        return $user_info;
    }
}


class MySQLUserInfo
{
    public function __construct()
    {
        $config = [
            'dsn' => 'mysql:dbname=master_slave;host=127.0.0.1;',
            'username' => 'homestead',
            'passwd' => 'secret',
        ];
        $this->pdo = new PDO($config['dsn'], $config['username'], $config['passwd']);
    }

    public function query(int $user_id): ?array
    {
        $stmt = $this->pdo->prepare('select * from student where id=?');

        $stmt->execute([$user_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC)[0] ?? null;
    }
}

class RedisUserInfo
{
    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('127.0.0.1', 6379);
    }
    

    public function getFromCache(int $user_id): ?array
    {
        $key = "user:$user_id:info";
        $fields = [
            "id",
            "name",
            "age",
            "address",
        ];
        return $this->redis->hMGet($key, $fields);
    }

    public function setToCache(int $user_id, array $user_info)
    {
        $key = "user:$user_id:info";
        return $this->redis->hMSet($key, $user_info);
    }
}




class Client
{
    public static function main()
    {
        $facade = new UserInfoFacade();

        $user_info = $facade->getUserInfo(2);

        var_dump($user_info);
    }
}


Client::main();









































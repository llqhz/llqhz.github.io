<?php

/**
 * 分布式ID生成器
 *
 * mysql: {id auto_increment, stub char(1)} => replace into stub => last_insert_id
 * redis: incr REDIS_UUID_KEY => return
 */


interface UUID
{
    public function get(): ?string;
}


/**
 * Class MySqlUUID
 */
class MySqlUUID implements UUID
{
    protected $pdo;

    public function __construct()
    {
        $config = [
            'dsn' => 'mysql:dbname=master_slave;host=127.0.0.1;port=3306',
            'username' => 'homestead',
            'passwd' => 'secret',
            'option' => [
                PDO::ATTR_PERSISTENT => true,
            ],
        ];
        $this->pdo = new PDO($config['dsn'], $config['username'], $config['passwd'], $config['option']);

        $this->tableInit();
    }

    protected function tableInit()
    {
        $table = '
            create table if not exists t_id_sequence (
                id bigint unsigned not null auto_increment primary key,
                stub char(1) not null default "",
                unique key stub(stub)
            ) engine=innodb default char set=utf8 auto_increment=10000;
        ';
        $this->pdo->exec($table);
    }

    public function get(): ?string
    {
        $stmt = $this->pdo->prepare('replace into t_id_sequence (stub) values (:val)');
        $ok = $stmt->execute([":val" => "a"]);
        if (!$ok) {
            return null;
        }

        return $this->pdo->lastInsertId();
    }
}


/**
 * Class RedisUUID
 */
class RedisUUID implements UUID
{
    const UUID_KEY = 'REDIS_UUID';

    protected $redis;

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('127.0.0.1', 6379);
    }

    public function get(): ?string
    {
        return $this->redis->incr(self::UUID_KEY);
    }
}




class Client
{
    public static function main()
    {
        $mysql_uuid = new MySqlUUID();
        $uuid_mysql = $mysql_uuid->get();

        $redis_uuid = new RedisUUID();
        $uuid_redis = $redis_uuid->get();

        var_dump(compact('uuid_mysql', 'uuid_redis'));
    }
}


Client::main();



































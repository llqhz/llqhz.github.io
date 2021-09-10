<?php

/**
 * 使用代理模式,完成学生信息缓存
 *
 * 1. get_from_redis -> get_from_mysql -> set_to_redis ->return
 */


interface Subject
{
    public function getUserInfo(int $student_id): ?array;
}

// 实际对象
class RealSubject implements Subject
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
    }

    public function __destruct()
    {
    }

    /**
     * 从数据库中查信息
     * @param int $student_id
     * @return array|null
     */
    public function getUserInfo(int $student_id): ?array
    {
        $sql = 'select * from student where id = :id';
        $statement = $this->pdo->prepare($sql);

        // 两种绑定方式
        # $statement->bindValue(':id', $student_id);
        $statement->execute([":id" => $student_id]);

        $students = $statement->fetchAll(PDO::FETCH_ASSOC);
        $student =  $students[0] ?? null;
        echo sprintf("get from mysql, key:[%s] value:[%s]\n", $student_id, json_encode($student));
        return $student;
    }
}

class SubjectProxy implements Subject
{
    protected $subject;

    protected $redis;

    public function __construct()
    {
        $this->subject = new RealSubject();

        $this->redis = new Redis();
        $this->redis->connect('127.0.0.1', 6379);
    }

    public function __destruct()
    {
        $this->redis->close();
    }

    /**
     * 实现代理
     * @param int $student_id
     * @return array|null
     */
    public function getUserInfo(int $student_id): ?array
    {
        $student = $this->getFromRedis($student_id);

        if (!$student) {
            $student = $this->subject->getUserInfo($student_id);

            if ($student) {
                $this->setRedisCache($student_id, $student);
            }
        }

        return $student;
    }

    protected function getFromRedis(int $student_id)
    {
        $key = sprintf("student_info:%s", $student_id);
        $student = $this->redis->get($key);
        if ($student) {
            $student = json_decode($student, true);
        }
        echo sprintf("get from redis, key:[%s] value:[%s]\n", $key, json_encode($student));
        return $student;
    }

    protected function setRedisCache(int $student_id, array $student)
    {
        $key = sprintf("student_info:%s", $student_id);
        return $this->redis->set($key, json_encode($student, JSON_UNESCAPED_UNICODE));
    }


    public static function main()
    {
        $proxy = new SubjectProxy();

        $student = $proxy->getUserInfo(5);

        var_dump($student);
    }
}


SubjectProxy::main();



<?php

// 朋友圈

function createTable() {
    // create database comments default charset=utf8;

    $sql = "
        create table t_contents (
            id bigint unsigned not null auto_increment primary key,
            user_id bigint unsigned not null,
            content varchar(1000) not null,
            parent_content_id bigint unsigned not null
        ) engine=innodb default charset=utf8;
    ";
}

function seed() {
    $item = [
        'user_id' => 1001,
        'content' => '',
        'parent_content_id' => 0,
    ];
    $content = 'this is a content';

    for ($i = 0; $i < 100; $i++) {
        $item['user_id'] = mt_rand(1000, 1010);
        $item['content'] = $content . mt_rand(1000, 1010);
        $item['parent_content_id'] = 0;

        $values = implode(',', array_map(function ($v) { return "'$v'"; }, $item));
        $sql = "insert into t_contents (user_id,content,parent_content_id) values ({$values})";
        execute($sql);
    }


}

function getContents() {
    $user_id = 1001;
    $limit = 10;
    $offset = 0;
    $sql = "select * from t_contents 
        where user_id='$user_id'
        order by id desc
        limit {$offset},{$limit}";
    $res = query($sql);
    var_dump($res);
}


function get_pdo() {
    return new PDO($dsn = 'mysql:host=127.0.0.1;port=33060;dbname=comments', 'homestead', 'secret');
}

function query($sql) {
    static $pdo;
    if (!$pdo) {
        $pdo = get_pdo();
    }
    echo $sql;

    $stmt = $pdo->prepare($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    return $stmt->fetchAll();
}

function execute($sql) {
    static $pdo;
    if (!$pdo) {
        $pdo = get_pdo();
    }
    $ok = $pdo->prepare($sql)->execute();

    if (!$ok) {
        $info = $pdo->errorInfo();
        $code = $pdo->errorCode();
        var_dump($info, $code);
        die();
    }

    return $ok;
}

abstract class AbstractClass {
    const I = 1;
    public $a = 1;

    public function test()
    {

    }
}

interface MInterface
{
    const I = 1;
    public function say();
}



function main() {
    // 获取评论
    getContents();

    // 填充数据
    // seed();

    // 展示结果

    $arr = [];

    foreach ($arr as $item):
        echo $item;
    endforeach;
}


(function () use ($argv) {
    // 闭包立即执行函数
})();


main();

function (object $a) {

}

try {
    xxx();

    $a = 'xxx';
    $a = &$a;

} catch (Error $e) {
    echo $e->getTraceAsString();
}
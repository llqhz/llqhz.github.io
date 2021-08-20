<?php

namespace process;

use Swoole\Process;
use Swoole\Table;


/**
* 共享内存(SwooleTable)
1. 定义
$table = new Table(1024);
$table->column('id', Table::TYPE_INT);

2. 申请
$table->create();

3. 使用
$table->get('3');
$table->set('3', ['id' => 3]);

# 共享内存, 非进程安全,需要自行使用同步机制
*/

// 定义SwooleTable
$table = new Table(1024);
$table->column('id', Table::TYPE_INT);
$table->column('name', Table::TYPE_STRING, 64);
$table->column('num', Table::TYPE_FLOAT);

// 向操作系统申请
$table->create();


$processes = [];

// 创建进程1
$process1 = new Process(function() use ($table) {
    sleep(2);
    $table->set('3', ['id' => 3, 'name' => 'process_111111', 'age' => 19.1]);
});
$processes[] = $process1;

// 创建进程2
$process2 = new Process(function() use ($table) {
    sleep(4);
    $table->set('3', ['id' => 3, 'name' => 'process_22222', 'age' => 19.2]);
});
$processes[] = $process2;


// 进程就绪
foreach ($processes as $process) {
    $process->start();
}

// 主进程操作table
for ($i = 0; $i <= 6; $i++) {
    $info = $table->get('3');
    echo 'get table from main process: ' . json_encode($info) . PHP_EOL;

    sleep(1);
}


// 主进程退出
while (false !== $ret = Process::wait(true)) {
    $res = [
        'code' => $ret['code'],
        'pid' => $ret['pid'],
        'signal' => $ret['signal'],
    ];
    echo 'sub process finished, info: ' . json_encode($res) . PHP_EOL;
}
echo 'main process finished.' . PHP_EOL;






























<?php


// 递归解法复杂度优化


// 普通递归, 存在重复计算
function fib ($n) {
    if ($n == 0 || $n == 1) {
        return 1;
    }
    return fib($n - 1) + fib($n - 2);
}




// 避免重复计算,将中间值带入递归流程中保存,递归过程中可以使用已保存的值


function fun($n, &$map = []) {
    if ($n == 0 || $n == 1) {
        return 1;
    }

    if (isset($map[$n])) {
        return $map[$n];
    }
    $res = fun($n - 1, $map) + fun($n - 2, $map);
    $map[$n] = $res;
    return $res;
}


$res = fun(30);
var_dump($res);




// dp数组,迭代解法

function fib_dp($n) {
    if ($n == 0) {
        return 0;
    }

    // base case
    $dp = [
        0 => 0,
        1 => 1,
    ];

    // 自底向上开始推导
    for ($i = 2; $i <= $n; $i++) {
        // 状态转移方程
        $dp[$i] = $dp[$i - 1] + $dp[$i - 2];
    }
    return $dp[$n];
}



// 状态压缩

function fib_dp_zip($n) {
    if ($n == 1 || $n == 2) {
        return 1;
    }

    // 只需要保存当前的两个状态即可
    $base_prev = 0;
    $base = 1;

    for ($i = 2; $i <= $n; $i++) {
        $now = $base + $base_prev;

        // 向下迭代, 两个状态都向前迁移
        $base_prev = $base;
        $base = $now;
    }

    return $now;
}



var_dump(fib_dp_zip(3));














































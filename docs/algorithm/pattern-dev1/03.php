<?php

// 多往「状态」和「选择」上靠

// 凑零钱问题



function coinChange ($coins, $amount) {

    return coinChangeDp($coins, $amount);

}

// 定义 m => coinChangeDp($coins, $amount)
// m代表配出amount需要的最少硬币数量, coins是当前可以选择的硬币,amount是需要凑出的金额

// 遍历当前选择,判断当前条件下的后面的选择
function coinChangeDp($coins, $amount) {
    if ($amount == 0) {
        return 0;
    }
    if ($amount < 0) {
        return -1;
    }

    $res = PHP_INT_MAX;
    foreach ($coins as $coin) {
        // 计算子问题的结果 (当前已经选择了coin)
        $m = coinChangeDp($coins, $amount - $coin);

        if ($m == -1) {
            continue;
        }

        // 在子问题中选择最优解
        $res = min($res, $m + 1);
    }

    return $res == PHP_INT_MAX ? -1 : $res;
}






$res = coinChange([1, 2, 5], 13);
var_dump($res);







// 添加备忘录


function coinChangeMem ($coins, $amount) {

    return coinChangeDpMem($coins, $amount);

}

/**
 * @param $coins
 * @param $amount
 * @param array $map
 * @return int 返回最小凑得数量
 */
function coinChangeDpMem($coins, $amount, &$map = []) {
    if (isset($map[$amount])) {
        return $map[$amount];
    }

    if ($amount == 0) {
        return 0;
    }
    if ($amount < 0) {
        return -1;
    }

    $res = PHP_INT_MAX;

    // 遍历当前次的所有选择,解决子问题
    foreach ($coins as $coin) {
        $m = coinChangeDpMem($coins, $amount - $coin);

        // 子问题无解跳过
        if ($m == -1) {
            continue;
        }

        // 合并解
        $res = min($res, $m + 1);
    }

    $map[$amount] = $res;
    return $res == PHP_INT_MAX ? -1 : $res;
}





// dp 数组的定义：当目标金额为 i 时，至少需要 dp[i] 枚硬币凑出。


function coinChangeDpArr ($coins, $amount) {
    // base case
    $dp = [0];

    for ($i = 1; $i <= $amount; $i++) {
        // 求dp[i] = dp[i-coin] + 1;
        $dpi_tmp = PHP_INT_MAX;
        foreach ($coins as $coin) {
            if (!isset($dp[$i - $coin]) || $dp[$i - $coin] == -1) {
                continue;
            }

            // 向上迭代
            $m = $dp[$i - $coin] + 1;
            $dpi_tmp = min($dpi_tmp, $m);
        }
        $dp[$i] = $dpi_tmp == PHP_INT_MAX ? -1 : $dpi_tmp;
    }

    return $dp[$i];
}





$m = coinChangeDpArr([1, 2, 5], 11);
var_dump($m);






















































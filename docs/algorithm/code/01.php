<?php

/**
 * 14 种算法面试模式
 *
 * 1. 滑动窗口
 *
 * 问题：从一个线性结构中找到最长/最短的子集
 * 实现：从第一个元素开始滑动窗口并逐个元素地向右滑，并根据你所求解的问题调整窗口的长度
 */


// 1. 大小为 K 的子数组的最大和
// 2. 带有 K 个不同字符的最长子字符串


/**
 *
 * 给你一个由 n 个元素组成的整数数组 nums 和一个整数 k 。
 * 请你找出平均数最大且 长度为 k 的连续子数组，并输出该最大平均数。
 *
 * 分析:窗口大小固定,求窗口的属性
 */



function findMaxAverage($nums, $k) {
    // 需要计算该属性
    $sum = 0;

    // 窗口初始化
    for ($i = 0; $i < $k; $i++) {
        $sum += $nums[$i];
    }

    // 移动窗口,纪录属性
    $max_start_index = 0;
    while ($i < count($nums)) {

        // 计算属性
        $sum_before = $sum;
        $sum = $sum + $nums[$i] - $nums[$i - $k];

        if ($sum > $sum_before) {
            $max_start_index = $i - $k;
        }

        // 移动窗口
        $i++;
    }

    return [
        'max_avg' => $sum / $k,
        'index' => [$max_start_index, $max_start_index + $k],
    ];
}


$res = findMaxAverage([1, -2 ,3, 5, -3, 3, -2, 6], 3);
var_dump($res);





/**
 *
 * 带有 K 个不同字符的最长子字符串
 *
 * 分析:窗口大小动态改变,求窗口的属性
 */


function findMaxDistinctChars($str, $k) {
    $map = [];

    $max_len = 0;
    $max_index = 0;

    $new_len = 0;
    $new_index = 0;
    foreach ($str as $i => $char) {
        if (!isset($map[$char])) {
            $map[$char] = 1;
            $max_len++;
            $new_len++;
            continue;
        }

        // 存在
        $new_len++;
    }
}

















































<?php

// 双指针碰撞

// 求一个排序数组的平方

// 求两个数的和为k
function get_sum_two ($arr, $k) {
    $l = 0;
    $r = count($k) - 1;  // 区间: [l,r]

    while ($l < $r) {
        $sum = $arr[$l] + $arr[$r];

        if ($sum == $k) {
            return [$l, $r];
        } elseif ($sum < $k) {
            $l++;
        } else {
            $r++;
        }
    }
    return null;
}


// 在有序数组中求总和为零的三元组
function get_sum_three($arr, $sum) {

}


































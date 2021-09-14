<?php

// 滑动窗口


// 窗口大小固定, 求大小为 K 的子数组的最大和
function get_sub_sum (array $arr, int $k) {
    $l = $r = 0;  // 窗口区间 [l,r]
    $sum = 0;     // 窗口属性

    $len = count($arr);

    // 初始化窗口属性
    $sum = array_sum(array_slice($arr, 0, $k));
    $r = $k;  // [0, k]

    while ($l <= $r && $r < $len) {
        $tmp = $sum + $arr[$r] - $arr[$l];
        $sum = max($sum, $tmp);

        // 向后移动窗口
        $r++;
    }
    return $sum;
}


// 最多带有K个不同字符的最长子字符串
// 输入：5 ，“leetcode” 输出：5—“tcode”
// 动态的滑动窗口

function get_sub_str (string $str, int $k) {
    $l = $r = 0;  // 窗口区间 [l,r]
    $len = strlen($str);

    $map = [];  // 窗口属性
    $sub_len = 0;

    while ($l <= $r && $r < $len && $sub_len == $k) {
        // 判断窗口属性
        if (!isset($map[$str[$r]])) {
            // 不存在重复,右指针移,扩大空间
            $map[$str[$r]] = 1;
            $r++;
            $sub_len++;
        } else {
            // 存在重复,左指针移,缩小空间
            unset($map[$l]);
            $l++;
            $sub_len--;
        }
    }

    return substr($str, $l, $sub_len);
}















<?php

// 二分查找



function binary_search($arr, $target) {
    $len = count($arr);

    $l = 0;
    $r = $len - 1;  // 区间定义 [l,r]

    while ($l <= $r) {
        $mid = floor(($l + $r) / 2);

        if ($target == $arr[$mid]) {
            return $mid;
        } elseif ($target > $arr[$mid]) {
            // 右边搜索
            $l = $mid + 1;
        } else {
            // 左边搜索
            $r = $mid - 1;
        }
    }

    return null;
}



$res = binary_search([1, 2, 3, 4, 5], 8);
var_dump($res);







































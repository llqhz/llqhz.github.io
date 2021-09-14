<?php


/**
 * 注意边界, 首先要明确边界变量代表的意义,以及是否包含
 * [a, b] => 包含a和b
 */


function binary_search(array $arr, $item) {
    // 定义搜索范围

    $l = 0;
    $r = count($arr) - 1;  // 代表在[l,r]中间搜索

    while ($l <= $r) {
        // 如果区间中有值,则进行搜索
        $mid = floor(($l + $r) / 2);

        if ($arr[$mid] == $item) {
            return $mid;
        } elseif ($item < $arr[$mid]) {
            // 在左区间搜索
            $r = $mid - 1;
        } else {
            // 在右区间搜索
            $l = $mid + 1;
        }
    }

    return -1;
}


function binary_search_v2 (array $arr, $item, $left = 0, $right = null) {
    if (is_null($right)) {
        $right = count($arr) - 1;
    }
    if ($left > $right) {
        return -1;
    }

    $mid = floor(($right + $left) / 2);

    if ($item == $arr[$mid]) {
        return $mid;
    } elseif ($item < $arr[$mid]) {
        return binary_search_v2($arr, $item, $left, $mid - 1);
    } else {
        return binary_search_v2($arr, $item, $mid + 1, $right);
    }
}

$index1 = binary_search([1, 3, 7, 9, 12], 8);
$index2 = binary_search_v2([1, 3, 7, 9, 12], 8);

var_dump($index1, $index2);
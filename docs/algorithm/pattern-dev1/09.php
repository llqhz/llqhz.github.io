<?php


// 二分查找



function binary_search($arr, $target) {
    // 定义区间 [low,high]
    $low = 0;
    $high = count($arr) - 1;

    while ($low <= $high) {
        $mid = floor(($low + $high) / 2);

        if ($arr[$mid] == $target) {
            return $mid;
        } elseif ($target > $arr[$mid]) {
            $low = $mid + 1;
        } else {
            $high = $mid - 1;
        }
    }

    return null;
}


function binary_search_v2($arr, $target) {

    return binary_search_v2_item($arr, $target, 0, count($arr) - 1);

}


function binary_search_v2_item($arr, $target, $low, $high) {

    if ($low > $high) {
        return -1;
    }

    $mid = floor(($low + $high) / 2);

    if ($arr[$mid] == $target) {
        return $mid;
    } elseif ($target > $arr[$mid]) {
        return binary_search_v2_item($arr, $target, $mid + 1, $high);
    } else {
        return binary_search_v2_item($arr, $target,  $low, $mid - 1);
    }
}






















































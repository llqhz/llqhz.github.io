<?php


// PHP实现非递归快速排序

// 递归实现版
// 选择第一个元素,然后小的放左边,大的放右边,递归
function quick_sort($arr) {
    if (empty($arr) || count($arr) == 1) {
        return $arr;
    }

    $p = $arr[0];
    $len = count($arr);

    $left = $right = [];
    for ($i = 1; $i < $len; $i++) {
        if ($arr[$i] <= $p) {
            $left[] = $arr[$i];
        } else {
            $right[] = $arr[$i];
        }
    }

    return array_merge(quick_sort($left), [$p], quick_sort($right));
}

/*
$arr = quick_sort([1, 3, 5, 4, 2]);
var_dump($arr);
*/

// 递归交换版本
function quick_sort_v2(&$arr, $left, $right) {
    if ($left < $right) {
        $p = partition($arr, $left, $right);
        quick_sort_v2($arr, $left, $p);
        quick_sort_v2($arr, $p + 1, $right);
    }
    return $arr;
}

function partition(&$arr, $left, $right) {
    $prov = $arr[$left];

    while ($left < $right) {
        // 找到需要交换的位置
        while ($left < $right && $arr[$right] > $prov) {
            $right--;
        }
        $arr[$left] = $arr[$right];
        while ($left < $right && $arr[$left] < $prov) {
            $left++;
        }
        $arr[$right] = $arr[$left];
    }

    $arr[$left] = $prov;
    return $left;
}


function swap (&$arr, $a, $b) {
    [$arr[$a], $arr[$b]] = [$arr[$b], $arr[$a]];
}


$arr = [1, 3, 5, 4, 2];




















































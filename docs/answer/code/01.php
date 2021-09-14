<?php


// PHP实现非递归快速排序

// 递归实现版
// 选择第一个元素,然后小的放左边,大的放右边,递归
function quick_sort($arr) {
    if (empty($arr)) {
        return $arr;
    }

    $p = $arr[0];

    $left = [];
    $right = [];

    foreach ($arr as $item) {
        if ($item <= $p) {
            $left[] = $item;
        } else {
            $right[] = $item;
        }
    }

    return array_merge(quick_sort($left), [$p], quick_sort($right));
}

// 递归交换版本
function quick_sort_v2($arr) {
    // 选择下标
    $p = 0;

    $len = count($arr);

    $prov = $p + 1;  // prov是个位置,保证左边的元素小于prov,保证小于的需要放的位置

    for ($i = $prov; $i < $len; $i++) {
        // 保证index位置的左边都<p
        if ($arr[$i] < $arr[$p]) {
            swap($arr, $i, $prov);
            $prov++;
        }
    }
}


function swap (&$arr, $a, $b) {
    [$arr[$a], $arr[$b]] = [$arr[$b], $arr[$a]];
}


















































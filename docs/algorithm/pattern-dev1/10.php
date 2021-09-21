<?php

// 快速排序


function quick_sort($arr) {
    if (count($arr) <= 1) {
        return $arr;
    }

    // 找到第一个值,分割成两部分
    $prov = $arr[0];

    $left = [];
    $right = [];

    for ($i = 1; $i < count($arr); $i++) {
        if ($arr[$i] <= $prov) {
            $left[] = $arr[$i];
        } else {
            $right[] = $arr[$i];
        }
    }

    return array_merge(quick_sort($left), [$prov], quick_sort($right));
}





function quick_sort_v2($arr) {
    // 分割成左右两部分

    $stack = new SplStack();
    $stack->push([0, count($arr) - 1]);  // 用一个栈保存递归的参数, 栈不为空就循环取出参数

    while (!$stack->isEmpty()) {
        [$low, $high] = $stack->pop();
        if ($low < $high) {
            $p = partition($arr, $low, $high);

            $stack->push([$low, $p - 1]);
            $stack->push([$p + 1, $high]);
        }
    }

    return $arr;
}


function partition(&$arr, $low, $high) {
    $prov = $arr[$low];

    while ($low < $high) {
        while ($low < $high && $arr[$high] > $prov) {
            $high--;
        }
        $arr[$low] = $arr[$high];
        while ($low < $high && $arr[$low] < $prov) {
            $low++;
        }
        $arr[$high] = $arr[$low];
    }

    $arr[$low] = $prov;
    return $low;
}

































































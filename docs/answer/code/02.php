<?php

// 快排非递归



// 分成两部分,最后再合并
function quick_sort($arr = []) {

    $stack = new SplStack();

    $stack->push([0, count($arr) - 1]);

    while (!$stack->isEmpty()) {
        [$low, $high] = $stack->pop();

        if ($low < $high) {
            $p = partition($arr, $low, $high);
            $stack->push([0, $p]);
            $stack->push([$p + 1, $high]);
        }
    }

    return $arr;
}

function partition (&$arr, $low, $high) {
    $prov = $arr[$low];

    while ($low < $high) {
        // 找到需要交换的索引
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







$arr = quick_sort([3, 5, 4, 7, 1, 2, 9, 0]);
var_dump($arr);






































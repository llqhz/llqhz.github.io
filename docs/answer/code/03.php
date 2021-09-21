<?php


// 快排非递归



function quick_sort($arr) {
    $stack = new SplStack();
    $stack->push([0, count($arr) - 1]);

    while (!$stack->isEmpty()) {
        [$low, $high] = $stack->pop();

        if ($low < $high) {
            $p = partition($arr, $low, $high);

            $stack->push([$low, $p]);
            $stack->push([$p + 1, $high]);
        }
    }

    return $arr;
}


function partition (&$arr, $low, $high) {
    $prov = $arr[$low];

    while ($low < $high) {
        // 找到需要交换的位置
        while ($low < $high && $arr[$high] > $prov) {
            $high--;
        }
        $arr[$low] = $arr[$high];

        // 找到需要交换的位置
        while ($low < $high && $arr[$low] < $prov) {
            $low++;
        }
        $arr[$high] = $arr[$low];
    }

    $arr[$low] = $prov;
    return $low;
}














































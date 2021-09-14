<?php

// 循环排序

// 遍历每个元素,将其与正确位置的索引替换


function cycle_sort($nums) {
    $i = 0;

    while ($i < count($nums)) {
        // place-index
        $p = $nums[$i] - 1;

        if ($p != $i) {
            // a is not at right place, swap.
            [$nums[$i], $nums[$p]] = [$nums[$p], $nums[$i]];
        } else {
            $i++;
        }
    }

    return $nums;
}



function find_missing_number ($nums) {
    $nums = cycle_sort($nums);

    foreach ($nums as $i => $v) {
        if ($i != $v) {
            return $i;
        }
    }
    return null;
}






















































































































































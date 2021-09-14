<?php


// 前k个最大数
// heap


function find_max_top_k ($arr, $k) {
    $max_heap = new SplMaxHeap();

    foreach ($arr as $item) {
        $max_heap->insert($item);
    }

    // 取出前k个
    $res = [];
    for ($i = 0; $i < $k; $i++) {
        $res[] = $max_heap->extract();
    }
    return $res;
}



































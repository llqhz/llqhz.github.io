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




function find_max_k($arr, $k) {
    $min_heap = new SplMinHeap();

    foreach ($arr as $item) {
        $min_heap->insert($item);

        if ($min_heap->count() > $k) {
            $min_heap->extract();
        }
    }

    $items = [];
    while (!$min_heap->isEmpty()) {
        $items[] = $min_heap->extract();
    }
    return $items;
}




$arr = range(1000, 2000);
$arr = array_merge($arr, range(10, 30));

var_dump(
  find_max_k($arr, 10)
);
























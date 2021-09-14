<?php

// 合并 K 个排序的列表


function merge_list($arr) {
    $heap = new SplMinHeap();

    foreach ($arr as $items) {
        foreach ($items as $item) {
            $heap->insert($item);
        }
    }

    $res = [];
    while (!$heap->isEmpty()) {
        $res[] = $heap->extract();
    }
    return $res;
}



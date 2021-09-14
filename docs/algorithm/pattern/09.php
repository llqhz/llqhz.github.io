<?php


// 双堆求中位数, 未排序的数组中求中位数

// 将数组分成两半, 小的部分存maxHeap, 大的部分存minHeap
// min-heap:[56789]  max-heap:[1234]  取最小堆的top


function find_medium ($arr) {
    $min_heap = new SplMinHeap();
    $max_heap = new SplMaxHeap();

    // 建立堆
    foreach ($arr as $item) {
        if ($min_heap->isEmpty()) {
            $min_heap->insert($item);
            continue;
        }

        // 对比
        if ($item > $min_heap->top()) {
            $min_heap->insert($item);

            if ($min_heap->count() - $max_heap->count() >= 2) {
                $max_heap->insert($min_heap->extract());
            }
        } else {
            // item<top
            $max_heap->insert($item);

            if ($max_heap->count() > $min_heap->count()) {
                // 保持min-heap的数量最多
                $min_heap->insert($max_heap->extract());
            }
        }
    }
    
    
    // 从堆中取出值
    if (($min_heap->count() + $max_heap->count()) % 2 == 0) {
        // 偶数取平均值
        return ($min_heap->top() + $max_heap->top()) / 2;
    }
    // 奇数直接取min-heap
    return $min_heap->top();
}

















































































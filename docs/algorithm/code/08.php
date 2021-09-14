<?php

//查找, set和map底层都是二分平衡搜索树, hash表(没有顺序性)


// 查找两个数组重复元素
function find_intersect_elements (array $a, array $b) {
    $map = [];
    foreach ($a as $item) {
        if (!isset($map[$item])) {
            $map[$item] = 1;
        }
    }

    $items = [];
    foreach ($b as $item) {
        if (isset($map[$item])) {
            $items[] = $item;
        }
    }
    return $items;
}
















































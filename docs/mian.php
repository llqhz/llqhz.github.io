<?php

// 归并排序


// 归并排序，先排序左部分，再排序右部分，最后合并
function merge_sort($arr = []) {
    $len = count($arr);

    if ($len <= 1) {
        return $arr;
    }

    $mid = floor($len / 2);

    $left = array_slice($arr, 0, $mid);
    $right = array_slice($arr, $mid);

    var_dump($left, $right);

    return merge_sort_item(merge_sort($left), merge_sort($right));
}

function merge_sort_item($left, $right)
{
    $temps = [];

    $i = $j = 0;
    while ($i < count($left) && $j < count($right)) {
        if ($left[$i] <= $right[$j]) {
            $temps[] = $left[$i];
            $i++;
        } else {
            $temps[] = $right[$j];
            $j++;
        }
    }

    while ($i < count($left)) {
        $temps[] = $left[$i];
        $i++;
    }
    while ($j < count($right)) {
        $temps[] = $right[$j];
        $j++;
    }
    return $temps;
}







// 快速排序, 大的放左，小的放右，然后合并
function quick_sort($arr = []) {
    $len = count($arr);

    if ($len <= 1) {
        return $arr;
    }

    // 分界线
    $prov = 0;

    $left = $right = [];
    for ($i = 1; $i < $len; $i++) {
        if ($arr[$i] < $arr[$prov]) {
            $left[] = $arr[$i];
        } else {
            $right[] = $arr[$i];
        }
    }

    return array_merge(quick_sort($left), [$arr[$prov]], quick_sort($right));
}


$arr = [1, 4, 6, 3, 2];
$arr = merge_sort($arr);

var_dump($arr);




































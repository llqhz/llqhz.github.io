<?php




// 计数排序, 时间复杂度 O(n)

/**
 * 保存排序值范围,对每个值进行计数,最后输出范围的每个值计数即可
 * @param array $arr
 * @return mixed
 */
function count_sort(array $arr) {

    $map = []; // value => count
    $min = $arr[0];
    $max = $arr[0];

    for ($i = 0; $i < count($arr); $i++) {
        if (!isset($map[$arr[$i]])) {
            $map[$arr[$i]] = 1;
        } else {
            $map[$arr[$i]]++;
        }

        if ($arr[$i] < $min) {
            $min = $arr[$i];
        }
        if ($arr[$i] > $max) {
            $max = $arr[$i];
        }
    }

    $items = [];
    for ($i = $min; $i <= $max; $i++) {
        if (isset($map[$i])) {
            $items = array_merge($items, array_pad([], $map[$i], $i));
        }
    }

    return $items;
}




$arr = count_sort([1, 3, 7, 5, 4, 2]);
var_dump($arr);
































































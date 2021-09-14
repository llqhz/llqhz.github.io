<?php

/**
 * 移动所有的0到数组末尾
 * 思路: 将非零元素移到前面,后面的元素直接赋值成0
 */

function move_zeros(array $arr) {
    $temps = [];

    foreach ($arr as $item) {
        if ($item != 0) {
            $temps[] = $item;
        }
    }

    return array_pad($temps, count($arr), 0);
}


/**
 * 遍历数组,发现元素不为0时,移动到k位置,k后面剩下的元素直接赋值为0
 * @param array $arr
 */
function move_zero_v2 (array $arr) {
    $k = 0;  // 保存

    // 将非0元素移到前k个位置
    for ($i = 0; $i < count($arr); $i++) {
        if ($arr[$i] != 0) {
            $arr[$k] = $arr[$i];
            $k++;
        }
    }

    // k后面的元素赋值为0
    for ($i = $k; $i < count($arr); $i++) {
        $arr[$i] = 0;
    }
    return $arr;
}


/**
 * 交换元素
 * @param array $arr
 * @return array
 */
function move_zero_v3 (array $arr) {
    $k = 0; // 前k位保持为非0元素

    for ($i = 0; $i < count($arr); $i++) {
        if ($arr[$i] != 0) {
            // 只要i不为0,就将其移动到k前面,(k++)
            if ($i != $k) {
                // i==k时,不需要交换
                list($arr[$k], $arr[$i]) = [$arr[$i], $arr[$k]];
            }
            $k++;
        }
    }

    return $arr;
}



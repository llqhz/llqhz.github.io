<?php

/**
 * 求数组的和为target
 */


function find_two_index ($arr, $target) {

    $len = count($arr);

    // 遍历两次求和
    for ($i = 0; $i < $len; $i++) {
        for ($j = $i + 1; $j < $len; $j++) {
            if ($arr[$i] + $arr[$i] == $target) {
                return [$i, $j];
            }
        }
    }

    return null;
}




/**
 * 先排序,再二分查找target-i
 */

function find_two_index_v2 ($arr, $target) {
    $len = count($arr);

    for ($i = 0; $i < $len; $i++) {

        $n = $target - $i;  // 在[$i+1,$len-1],查找$n即可
        $index2 = binary_search_v2($arr, $n, $i+1, $len-1);
        if ($index2 != -1) {
            return [$i, $index2];
        }
    }

    return null;
}

/**
 * 双指针,从两头开始,向中间靠拢,用while控制指针双前移条件
 */

function find_two_index_v3 ($arr, $target) {
    $len = count($arr);

    $i = 0;
    $j = $len - 1;
    while ($i < $j) {
        $sum = $i + $j;
        if ($sum == $target) {
            return $target;
        } elseif ($sum < $target) {
            $i++;
        } else {
            // sum > target
            $j++;
        }
    }
    return null;
}



/**
 * 判断字符串是否是回文串, 双指针对撞
 * ord('A'):65  ord('Z'):90  ord('a'):97
 */
function check_str_is_valid($str) {
    $i = 0;
    $j = strlen($str) - 1;

    while ($i < $j) {
        if ($str[$i++] != $str[$j--]) {
            return false;
        }
    }
    return true;
}


/**
 * 原地反转字符串, 双指针
 */
function str_reverses($str) {
    $i = 0;
    $j = strlen($str);

    while ($i++ < $j--) {
        list($str[$i], $str[$j]) = [$str[$j], $str[$i]];
    }

    return $str;
}


























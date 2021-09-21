<?php


// 统计字符串出现最多的字数

function find_count ($str = '') {
    $map = [];
    for ($i = 0; $i < strlen($str) - 1; $i++) {
        if (!isset($map[$i])) {
            $map[$i] = 1;
        } else {
            $map[$i]++;
        }
    }

    $i = 0;
    $max = 0;
    foreach ($map as $index => $cnt) {
        if ($cnt > $max) {
            $max = $cnt;
            $i = $index;
        }
    }

    return $i;
}





































// n个整数找其中唯一的一个重复的数字


function find($arr = []) {
    $map = [];
    foreach ($arr as $k => $item) {
        if (!isset($map[$item])) {
            $map[$item] = 1;
        } else {
            return $k;
        }
    }
    return -1;
}








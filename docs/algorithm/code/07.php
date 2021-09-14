<?php

// 滑动窗口


// 找到最短子数组,sum>=s,返回其个数
function find_max_len ($arr, $s) {
    $i = 0;
    $j = $i + 1;
    $res = PHP_INT_MAX;
    $sum = $arr[$i] + $arr[$j];

    while ($i < $j && $j < count($arr)) {
        if ($sum >= $s){
            $res = min($res, $j - $i);
            $i++;
            $sum += $arr[$i];
        } else {
            $sum -= $arr[$j];
            $j++;
        }
    }

    return $res === PHP_INT_MAX ? false : $res;
}


/**
 * 找出无重复的字符串
 */
function find_sub_str_len ($str) {

    $len = strlen($str);
    $l = $r = 0;  // 窗口区间([$l, $r])
    $map = [];    // 窗口属性
    $res = $max = 0;     // 解


    while ($l <= $r && $r < $len) {
        // 判断右边界,从[0,0]开始判断
        if (!isset($map[$str[$r]])) {
            $map[$str[$r]] = 1;
            $r++;
            $res++;
            $max = max($max, $res);
        } else {
            unset($map[$str[$l]]);
            // 移动窗口
            $l++;
            $res--;
        }
    }

    return $max;
}



$sub_str = find_sub_str_len('asdajabca');
echo "sub_str:" . $sub_str . PHP_EOL;



























































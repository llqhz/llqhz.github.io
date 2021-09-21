<?php


// 最长无重复子串长度

function max_sub_str($str) {
    $left = $right = 0;

    $map = [];
    $res = 0;

    while ($right < strlen($str)) {
        $char = $str[$right];
        $right++;

        if (!isset($map[$char])) {
            // 不存在
            $map[$char] = 1;
        } else {
            // 存在,缩小窗口
            $left++;
        }

        // 在这里更新答案
        $res = max($res, $right - $left);
    }

    return $res;
}





















































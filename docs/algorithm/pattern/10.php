<?php


// 求数组的所有子集

// 原来的不动,直接拷贝一份新增的


function get_all_sub_array($nums) {

    $res = [[]];
    foreach ($nums as $num) {
        $new_sub_arrays = $res;
        foreach ($res as $i => $item) {
            $new_sub_arrays[$i][] = $num;
        }
        // 原来的不动,直接拷贝一份新增的
        $res = array_merge($res, $new_sub_arrays);
    }

    return $res;
}



$res = get_all_sub_array($nums = [1, 2, 3]);
echo json_encode($res);



















































<?php


// 回溯法

// 其实回溯算法其实就是我们常说的 DFS 算法，本质上就是一种暴力穷举算法。

// 解决一个回溯问题，实际上就是一个决策树的遍历过程。



function solution ($nums = []) {

    backtrack($nums, $visited = [], $res);

    return $res;
}


function backtrack($nums = [], $visited = [], &$res = []) {
    // 遍历到最后时,加入visited
    if (count($nums) == count($visited)) {
        $res[] = $visited;
        return;
    }


    foreach ($nums as $num) {
        if (in_array($num, $visited)) {
            continue;
        }

        $visited[] = $num;
        backtrack($nums, $visited, $res);
        array_pop($visited);
    }
}




$list = solution([1, 2, 3]);
var_dump($list);


























































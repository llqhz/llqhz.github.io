<?php


/**
 * @param $arr
 * [0, 1, 2]
 * [3, 4, 5]
 * [6, 7, 8]
 *
 * [0, 1, 0]
 * [3, 4, 1]
 * [6, 7, 2]
 *
 * (0,0) => (0,2)
 * (0,1) => (1,2)
 * (0,2) => (2,2)
 *
 * (1,0) => (0,1)
 * (1,1) => (1,1)
 * (1,2) => (2,1)
 */

function solution ($arr) {
    $tmps = [];
    $len = count($arr);

    foreach ($arr as $i => $items) {
        foreach ($items as $j => $item) {
            $tmps[$j][$len - $i - 1] = $item;
        }
    }

    return $tmps;
}

function pp ($arr){
    foreach ($arr as $items) {
        echo json_encode($items) . PHP_EOL;
    }
    echo PHP_EOL;
}

$arr = [
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9],
];
pp($arr);

$res = solution($arr);

pp($res);
































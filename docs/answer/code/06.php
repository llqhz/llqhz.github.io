<?php


$arr = [1, 2, 3, 4];

$ok = array_walk($arr, function (&$value) {
    $value .= '1';
});


$arr = array_map(function ($v1, $v2) {
    return $v1;
}, $arr1 = ['a1', 'a2'], $arr2 = ['b1', 'b2']);

var_dump($arr);


















































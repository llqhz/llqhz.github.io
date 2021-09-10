<?php

// preg_replace

$str = 'test_words';

$res = preg_replace_callback('/_\w/m', function ($value) {
    return strtoupper(ltrim(implode($value), '_'));
}, $str);

var_dump($res);


echo str_replace(' ', '', ucwords(str_replace('_', ' ', $str)));



<?php

/**
 * 实践复杂度概念
 */


function calculate($n) {
    $start_time = microtime(true);
    $sum = 0;
    for ($i = 0; $i < $n; $i++) {
        $sum += $i % 2 ? 1 : -1;
    }
    return microtime(true) - $start_time;
}


for ($i = 1; $i < 9; $i++) {
    $time = calculate(pow(10, $i));

    echo "num: 10^{$i}, time:" . $time . PHP_EOL;
}



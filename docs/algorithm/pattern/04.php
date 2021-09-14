<?php


// 合并区间, 对重叠的区间进行合并

function merge_intervals(array $intervals) {
    // 先按区间左端点排序
    usort($intervals, function ($item1, $item2) {
        return $item1[0] > $item2[0];
    });

    $merged = [];

    foreach ($intervals as $interval) {
        if (empty($merged)) {
            $merged[] = $interval;
            continue;
        }

        $last = $merged[count($merged) - 1];

        // 不连续的就直接添加
        if ($interval[0] > $last[1]) {
            $merged[] = $interval;
            continue;
        }

        // 连续的就合并
        $last[1] = max($last[1], $interval[1]);
        $merged[count($merged) - 1] = $last;
    }

    return $merged;
}



































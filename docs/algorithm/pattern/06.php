<?php

// 原地反转链表

// 需要有三个指针, prev, curr, 后借助next


function list_reverse($head) {
    $curr = $head;
    $prev = null;

    while ($curr) {
        // prev curr next (三者位置)

        $next = $curr->next;

        $curr->next = $prev;
        $prev = $curr;
        $curr = $next;
    }

    return $prev;
}










































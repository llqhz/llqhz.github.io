<?php

// 快慢指针

// 判断链表是否有环, 快指针移动两次,慢指针移动一次,每次移动,两者的距离都会增加1

function has_cycle($head) {
    $slow = $head;
    $fast = $head;

    while ($fast && $fast->next) {
        $fast = $fast->next->next;
        $slow = $slow->next;

        if ($fast == $slow) {
            return true;
        }
    }

    return false;
}


// 回文链表（中等）
















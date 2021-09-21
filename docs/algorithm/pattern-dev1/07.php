<?php


class ListNode {
    public $val = 0;
    public $next = null;
    function __construct($val = 0, $next = null) {
        $this->val = $val;
        $this->next = $next;
    }
}

// 单链表的倒数第 k 个节点

function find_last_k (ListNode $node, int $k) {

    // 两者相距k
    $p1 = $node;
    $p2 = $node;
    for ($i = 0; $i < $k; $i++) {
        $p2 = $p2->next;
    }

    while ($p2 != null) {
        $p2 = $p2->next;
        $p1 = $p1->next;
    }

    return $p1;
}


// 用两个相距为k的指针,同时遍历,当尾指针指向null时,头指针就指向了last_k


























































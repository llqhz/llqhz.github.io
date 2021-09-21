<?php

// 合并 K 个排序的列表


function merge_list($arr) {
    $heap = new SplMinHeap();

    foreach ($arr as $items) {
        foreach ($items as $item) {
            $heap->insert($item);
        }
    }

    $res = [];
    while (!$heap->isEmpty()) {
        $res[] = $heap->extract();
    }
    return $res;
}



class ListNode {
    public $val = 0;
    public $next = null;
    function __construct($val = 0, $next = null) {
        $this->val = $val;
        $this->next = $next;
    }
}

function merge_list_v2($lists = []) {

    if (count($lists) == 0) {
        return null;
    }

    $heap = new SplMinHeap();

    foreach ($lists as $node) {
        $heap->insert($node);
    }

    $list = new ListNode(-1);
    $curr = $list;

    while (!$heap->isEmpty()) {
        $p = $heap->extract();
        $curr->next = new ListNode($p->val);

        $heap->insert($curr->next);

        $curr = $curr->next;
    }

    return $list->next;
}


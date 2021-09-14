<?php


// 二叉树的层级遍历

// 将当前元素入队后,开始遍历队列直到为空

function level_traversal($head) {
    $curr = $head;

    $levels = [];

    $queue = new SplQueue();
    $queue->enqueue($curr);

    while (!$queue->isEmpty()) {
        // 出队并访问该结点
        $node = $queue->pop();
        $levels[] = $node;

        // 左右子节点入队,再打印该结点
        if ($node->left) {
            $queue->enqueue($node->left);
        }
        if ($node->right) {
            $queue->enqueue($node->right);
        }
    }
    return $levels;
}





























































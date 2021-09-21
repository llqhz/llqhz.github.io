<?php

// 求二叉树的最小高度


// 二叉树的层级遍历

class Node
{
    public $left;
    public $right;
}


function level_traversal(Node $root) {
    if ($root == null) {
        return 0;
    }

    $queue = new SplQueue();
    $queue->enqueue($root);

    $step = 0;

    while (!$queue->isEmpty()) {
        $curr = $queue->dequeue();
        if (is_null($curr)) {
            return $step;
        }

        $queue->enqueue($curr->left);
        $queue->enqueue($curr->right);

        $step++;
    }
    return $step;
}


































































<?php



// 二叉树的后序遍历

function traversal_after ($head) {
    $curr = $head;

    // 先遍历其左,再遍历右,最后中
    if (is_null($curr)) {
        return [];
    }
    $res = [];

    $res = array_merge($res, traversal_after($head->left));
    $res = array_merge($res, traversal_after($head->right));

    // 遍历当前结点
    $res = array_merge($res, [$head]);
    return $res;
}




// https://leetcode-cn.com/problems/path-sum/solution/lu-jing-zong-he-by-leetcode-solution/


// 路径总和

function path_sum ($head, $sum) {
    $curr = $head;

    // queue [$node, curr_node_sum]
    $queue = new SplQueue();

    $queue->enqueue([$curr, $curr->data]);

    while (!$queue->isEmpty()) {
        [$curr, $node_sum] = $queue->dequeue();

        // 叶子结点对比路径和
        if (!$curr->left && !$curr->right) {
            return $node_sum == $sum;
        }

        // 计算子节点的路径和
        if ($curr->left) {
            $queue->enqueue([$curr->left, $node_sum + $curr->left->data]);
        }
        if ($curr->right) {
            $queue->enqueue([$curr->right, $node_sum + $curr->right->data]);
        }
    }
    return false;
}




















































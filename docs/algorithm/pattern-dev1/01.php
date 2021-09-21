<?php


// LRU缓存机制

// 原理, hash存数据, list存键的顺序

class LRUCache {

    public $capacity = 0;

    protected $map = [];  // 存储key=>node映射

    protected $list;  // 存储 [key, value]

    /**
     * @param Integer $capacity
     */
    function __construct($capacity) {
        $this->capacity = $capacity;
        $this->list = [];
    }

    /**
     * 查结点,移动到链表头部
     * @param Integer $key
     * @return Integer
     */
    function get($key) {
        if (!isset($this->map[$key])) {
            return -1;
        }
        $node = $this->map[$key];

        $this->moveNodeToTop($node);

        return $node['value'];
    }

    /**
     * 放入结点,移动到链表头部
     * 如果数量超过,则移除最后一个结点
     * @param Integer $key
     * @param Integer $value
     * @return NULL
     */
    function put($key, $value) {
        if (isset($this->map[$key])) {
            // 移动到头部
            $node = $this->map[$key];
            $node['value'] = $value;

            $this->map[$key] = $node;
        } else {
            if (count($this->map) == $this->capacity) {
                // 达到了容量,需要先删除
                $this->removeEnd();
            }

            $node = ['key' => $key, 'value' => $value];
            $this->map[$key] = $node;
        }

        $this->moveNodeToTop($node);
    }

    /**
     * 存在则先删除
     */
    protected function moveNodeToTop($node)
    {
        $index = null;
        foreach ($this->list as $i => $item) {
            if ($item['key'] == $node['key']) {
                $index = $i;
                break;
            }
        }
        if (!is_null($index)) {
            // 移除
            array_splice($this->list, $index, 1);
        }

        // 放到首部
        array_unshift($this->list, $node);
    }

    protected function removeEnd()
    {
        $node = array_pop($this->list);
        unset($this->map[$node['key']]);
    }
}









































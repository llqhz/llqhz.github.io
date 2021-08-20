<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'cache.php';


/**
 * Class LFUCache
 * 最少使用
 * 用一个队列保存cache数据,当cache满时,再存入就pop出最先进队列的,然后再存
 */
class LFUCache extends Cache
{
    /**
     * @var DoubleLinkedList[]
     * [ 1=>{()->()} 2=>{()=>()} ]
     */
    protected $freqMap = [];

    /**
     * @var LFUNode[]
     */
    protected $map;

    public function __construct($capacity)
    {
        parent::__construct($capacity);
    }

    /**
     * 更新结点频率,将结点从当前频率链表中删除,并push到新频率链表中
     * @param LFUNode $node
     */
    protected function update_freq(LFUNode $node)
    {
        $freq = $node->freq;

        // 将结点频率上移
        if (isset($this->freqMap[strval($freq)])) {
            $linkedList = $this->freqMap[$freq];
            $linkedList->remove($node);

            // 如果全部淘汰
            if (!$linkedList->size) {
                unset($this->freqMap[$freq]);
            }
        }

        // 上移
        $freq++;
        if (isset($this->freqMap[strval($freq)])) {
            // 存在则取
            $newLinkedList = $this->freqMap[$freq];
        } else {
            // 不存在则新建
            $newLinkedList = new DoubleLinkedList();
        }
        $node->freq = $freq;
        $newLinkedList->lPush($node);

        $this->freqMap[strval($freq)] = $newLinkedList;
    }
    
    public function get($key)
    {
        if (!isset($this->map[$key])) {
            return null;
        }

        $node = $this->map[$key];

        // 更新node频率
        $this->update_freq($node);
        return $node->value;
    }

    // 存缓存
    public function put($key, $value): bool
    {
        if (!$this->capacity) {
            return false;
        }

        if (isset($this->map[$key])) {
            // 如果命中,频率前移
            $node = $this->map[$key];

            // 更新数值
            $node->value = $value;
            $this->map[$key] = $node;

            // 更新频率
            $this->update_freq($node);
            $this->size++;
            return true;
        }

        // 未命中
        // 是否溢出
        if ($this->capacity == $this->size) {
            // 溢出 -> 淘汰
            $freq = min(array_keys($this->freqMap));
            $linkedList = $this->freqMap[$freq];
            $old_node = $linkedList->rPop();
            unset($this->map[$old_node->key]);

            // 如果全部淘汰
            if (!$linkedList->size) {
                unset($this->freqMap[$freq]);
            }
            $this->size--;
        }
        // 数值
        $node = new LFUNode($key, $value);
        $this->map[$key] = $node;

        // 频率
        $this->update_freq($node);
        $this->size++;
        return true;
    }

    public function print()
    {
        foreach ($this->freqMap as $freq => $linkedList) {
            echo sprintf('freq: %s ', $freq);
            $linkedList->print();
        }
        echo json_encode(array_keys($this->map ?: [])) . PHP_EOL;
    }
}


class LFUNode extends Node
{
    public $freq = 0;
}


LFUCache::test();



<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'cache.php';


/**
 * Class FIFOCache
 * 先进先出
 * 用一个队列保存cache数据,当cache满时,再存入就pop出最先进队列的,然后再存
 */
class FIFOCache extends Cache
{
    public function get($key)
    {
        if (!isset($this->map[$key])) {
            return null;
        }
        $node = $this->map[$key];
        return $node->value;
    }

    public function put($key, $value): bool
    {
        if (!$this->capacity) {
            return false;
        }
        if (isset($this->map[$key])) {
            $node = $this->map[$key];
            // 出队列
            $this->linkedList->remove($node);

            // 新入队列
            $node->value = $value;
            $this->linkedList->lPush($node);

            // 入队1,出队1,个数不变
        } else {
            // 新入队列
            if ($this->size == $this->capacity) {
                // 缓存淘汰,先进的先出
                $node = $this->linkedList->rPop();
                unset($this->map[$node->key]);
                $this->size--;
            }

            $node = new Node($key, $value);
            $this->linkedList->lPush($node);
            $this->map[$key] = $node;
            $this->size++;
        }
        return true;
    }
}


FIFOCache::test();

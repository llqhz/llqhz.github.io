<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'cache.php';


/**
 * Class LRUCache
 * 最近最少使用
 * 用链表纪录顺次存入的key,get时将key移到队首
 */
class LRUCache extends Cache
{
    public function get($key)
    {
        if (!isset($this->map[$key])) {
            return null;
        }

        // 如果存在,则移位到队首
        $node = $this->map[$key];
        $this->linkedList->remove($node);
        $this->linkedList->lPush($node);
        return $node->value;
    }

    public function put($key, $value): bool
    {
        if (isset($this->map[$key])) {
            // 如果存在,则更新key,并移位到队首
            $node = $this->map[$key];
            $this->linkedList->remove($node);
            $this->linkedList->lPush($node);
        } else {
            // 不存在,则添加到队首
            if ($this->size == $this->capacity) {
                // 添加时,如果溢出,则进行缓存淘汰策略,移除队尾
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


LRUCache::test();


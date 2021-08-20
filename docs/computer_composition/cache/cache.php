<?php

class Node 
{
    public $key;
    public $value;
    /**
     * @var Node
     */
    public $prev;
    /**
     * @var Node
     */
    public $next;

    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }
}

class DoubleLinkedList
{
    /**
     * @var Node
     */
    public $head;
    /**
     * @var Node
     */
    public $tail;
    public $size = 0;

    public function lPush(Node $node)
    {
        $node->next = $this->head;
        if ($node->next) {
            $node->next->prev = $node;
        } else {
            $this->tail = $node;
        }
        $this->head = $node;
        $this->size++;
    }

    public function rPush(Node $node)
    {
        $node->prev = $this->tail;
        if ($node->prev) {
            $node->prev->next = $node;
        } else {
            $this->head = $node;
        }
        $this->tail = $node;
        $this->size++;
    }

    public function lPop(): ?Node
    {
        if (!$this->head) {
            return null;
        }
        $node = $this->head;
        if ($node->next) {
            $node->next->prev = null;
        }
        $this->head = $node->next;
        $node->next = null;
        $this->size--;
        return $node;
    }

    public function rPop(): ?Node
    {
        if (!$this->tail) {
            return null;
        }
        $node = $this->tail;
        if ($node->prev) {
            $node->prev->next = null;
        }
        $this->tail = $node->prev;
        $node->prev = null;
        $this->size--;
        return $node;
    }

    public function remove(Node $node): ?Node
    {
        $pNode = $this->head;
        while ($pNode) {
            if ($pNode === $node) {
                // 移除
                if ($pNode->prev) {
                    // 有prev,则头部不变
                    $pNode->prev->next = $pNode->next;
                } else {
                    // 没有prev,则头部也下移
                    $this->head = $pNode->next;
                }
                if ($pNode->next) {
                    // 有next,则尾部不变
                    $pNode->next->prev = $pNode->prev;
                } else {
                    // 没有next,则尾部也前移
                    $this->tail = $pNode->prev;
                }
                // 维护首尾指针

                $pNode->prev = null;
                $pNode->next = null;
                $this->size--;
                return $pNode;
            }

            $pNode = $pNode->next;
        }
        return null;
    }

    public function print()
    {
        $node = $this->head;
        $line = '';
        while ($node) {
            $line .= sprintf("(%s,%s)", $node->key, $node->value);
            $node = $node->next;

            if ($node) {
                $line .= '=>';
            }
        }
        echo $line, $line ? PHP_EOL : "";
    }
}




class NodeClient
{
    public static function main()
    {
        $l = new DoubleLinkedList();
        $l->print();
        $l->lPop();
        $l->rPop();

        $nodes = array_map(
            function ($k) {
                return new Node($k, $k);
            },
            range(0, 100)
        );

        $l->lPush($nodes[0]);
        $l->lPush($nodes[1]);
        $l->lPush($nodes[2]);
        $l->lPush($nodes[3]);
        $l->lPush($nodes[4]);
        $l->rPush($nodes[5]);
        $l->rPush($nodes[6]);
        $l->rPush($nodes[7]);
        $l->print();

        $l->lPop();
        $l->rPop();
        $l->remove($nodes[1]);
        $l->print();
    }
}


// NodeClient::main();



abstract class Cache
{
    protected $capacity;
    protected $size = 0;
    /**
     * @var Node[] 用node的key->value来存值
     */
    protected $map;
    /**
     * @var DoubleLinkedList 队列
     */
    protected $linkedList;

    public function __construct($capacity)
    {
        $this->capacity = $capacity;
        $this->linkedList = new DoubleLinkedList();
    }

    abstract public function get($key);
    abstract public function put($key, $value): bool;

    public function print()
    {
        $this->linkedList->print();
        echo json_encode(array_keys($this->map ?: [])) . PHP_EOL;
    }

    public static function test()
    {
        $cache = new static(5);

        array_map(
            function ($k) use ($cache) {
                $cache->put(strval($k), strval($k));
            },
            range(1, 10)
        );

        $cache->print();

        var_dump($cache->get('6'));

        $cache->put('11', '11');
        $cache->put('12', '12');
        $cache->print();
    }
}




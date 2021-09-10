<?php

/**
 * 一致性hash算法
 *
 * 原理: 每一次hash64个int, 根据key的hash值判断落在哪个区间决定哪个node去处理
 * aint1 bint1 cint1 aint2 cint2 bint2
 */


class HashServer
{
    // node=>point映射
    protected $node_key_virtual_id_map = [];

    // point=>node映射
    protected $virtual_id_node_key_map = [];

    const MUL = 64; // 64个虚拟节点, 需要映射到nodes上

    protected function hash($key)
    {
        return sprintf("%u", crc32($key));
    }

    public function addNode($node_key)
    {
        // 初始化
        $this->node_key_virtual_id_map[$node_key] = [];

        for ($i = 0; $i < self::MUL; $i++) {
            // 生成MUL个虚拟节点
            $virtual_hash_key = $node_key .'_hash_' . $i;
            $virtual_id = $this->hash($virtual_hash_key);

            // 添加双向map
            $this->virtual_id_node_key_map[$virtual_id] = $node_key; // 这些虚拟节点都指向node_key
            $this->node_key_virtual_id_map[$node_key][] = $virtual_id;
        }

        ksort($this->virtual_id_node_key_map);
    }

    public function lookup($key)
    {
        $hash_key = $this->hash($key);

        foreach ($this->virtual_id_node_key_map as $virtual_id => $node_key) {
            if (intval($hash_key) <= intval($virtual_id)) {
                return $node_key;
            }
        }

        return reset($this->virtual_id_node_key_map);
    }

    public function addNodes($node_keys)
    {
        foreach ($node_keys as $node_key) {
            $this->addNode($node_key);
        }
    }
}


class Client
{
    public static function main()
    {
        $server = [];
        $server['A'] = ['host' => 'localhost', 'port' => 10001];
        $server['B'] = ['host' => 'localhost', 'port' => 10002];
        $server['C'] = ['host' => 'localhost', 'port' => 10003];
        $server['D'] = ['host' => 'localhost', 'port' => 10004];
        $server['E'] = ['host' => 'localhost', 'port' => 10005];

        $hash = new Hash();
        $hash->addNodes(array_keys($server));
    }
}























































<?php


class Sentinel
{
    const SENTINELS = [
        [
            'ip' => '192.168.20.11',
            'port' => 26379,
        ],
        [
            'ip' => '192.168.10.12',
            'port' => 26379,
        ],
    ];

    const MASTER_NAME = 'mymaster';

    protected $redis_master;
    protected $redis_slave;
    protected $sentinel;

    public function __construct()
    {
        $this->sentinel = new Redis();

        foreach (self::SENTINELS as $sentinel) {
            $ok = $this->sentinel->connect($sentinel['ip'], $sentinel['port']);
            if ($ok) {
                break;
            }
        }
    }

    public function getMaster()
    {
        return $this->sentinel->rawCommand('sentinel', 'masters', self::MASTER_NAME);
    }

    public function getSlaves()
    {
        return $this->sentinel->rawCommand('sentinel', 'slaves', self::MASTER_NAME);
    }

    public function getRedisMaster()
    {
        $master = $this->getMaster();

        if (!$this->redis_master) {
            $this->redis_master = new Redis();
            $this->redis_master->connect($master['ip'], $master['port']);
        }

        return $this->redis_master;
    }

    public function getRedisSlave()
    {
        $slaves = $this->getSlaves();

        // 负载均衡
        $slave = array_rand($slaves);

        if (!$this->redis_slave) {
            $this->redis_slave = new Redis();
            $this->redis_slave->connect($slave['ip'], $slave['port']);
        }

        return $this->redis_slave;
    }
}

class Client
{
    public static function main()
    {
        $sentinel = new Sentinel();

        $master = $sentinel->getMaster();

        $slaves = $sentinel->getSlaves();

        var_dump(compact('master', 'slaves'));
    }
}

Client::main();



























































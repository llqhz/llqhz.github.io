<?php

// 策略模式,通过hashMap映射,去除if-else


class Solution
{
    protected $map = [];


    public function __construct()
    {
        $this->map = [
            'A' => new A(),
            'B' => new B(),
        ];
    }

    public function operate($type, $params)
    {
        $strategy = $this->map[$type];

        assert($strategy instanceof Strategy, 'strategy not found.');

        $strategy->operate($params);
    }
}

interface Strategy
{
    public function operate();
}

class A implements Strategy
{
    public function operate()
    {
        // TODO: Implement operate() method.
    }
}

class B implements Strategy
{
    public function operate()
    {
        // TODO: Implement operate() method.
    }
}









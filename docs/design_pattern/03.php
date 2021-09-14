<?php

// 观察者模式

// observer_container + observer


class ObserverContainer
{
    protected $list = [];

    public function attach(Observer $observer)
    {
        $this->list[] = $observer;
    }

    public function detach(Observer $observer)
    {
        $index = null;
        foreach ($this->list as $i => $ob) {
            if ($ob == $observer) {
                $index = $i;
                break;
            }
        }

        array_splice($this->list, $index, 1);
    }

    public function notify()
    {
        foreach ($this->list as $observer) {
            $observer->update($this);
        }
    }
}


interface Observer
{
    public function update(ObserverContainer $container);
}

class Observer1 implements Observer
{
    public function update(ObserverContainer $container)
    {
        
    }
}

class Observer2 implements Observer
{
    public function update(ObserverContainer $container)
    {

    }
}


















































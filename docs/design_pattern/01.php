<?php

// 单例模式



class Singleton
{
    public static $instance;

    protected function __construct()
    {
        
    }

    public static function getInstance()
    {
        if (!static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    protected function __clone()
    {
            
    }
}




<?php

namespace App\Traits;

trait Singleton
{
    private static $instance;

    protected function __construct()
    {}

    public static function getInstance($data = null)
    {
        if (!self::$instance) {
            // new self() will refer to the class that uses the trait
            self::$instance = new self($data);
        }

        return self::$instance;
    }

    public function __clone()
    {}
    public function __sleep()
    {}
    public function __wakeup()
    {}
}

<?php

namespace Pluckypenguinphil\Battlesnake\Traits;

use Pluckypenguinphil\Battlesnake\Log;

trait SingletonAccessor
{
    private static ?self $_instance = null;

    private function __construct()
    {
        //
    }

    public static function instance(): self
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}

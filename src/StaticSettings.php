<?php

namespace Pluckypenguinphil\Battlesnake;

use Pluckypenguinphil\Battlesnake\Traits\SingletonAccessor;

/**
 * @property-read array $snake[apiversion, author, color, head, tail, version]
 * @property-read array $app[debug]
 */
class StaticSettings
{
    use SingletonAccessor;

    private array $settings;

    private function __construct()
    {
        $this->settings = $_ENV;
    }

    public function __get($key)
    {
        return $this->settings[$key];
    }
}

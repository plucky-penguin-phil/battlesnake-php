<?php

namespace Pluckypenguinphil\Battlesnake\Structs;

abstract class Struct
{
    private array $methods = [];

    public function __construct(array $args)
    {
        foreach ($args as $key => $value) {
            $this->$key = $value;
        }
    }

    public function __get($key)
    {
        if (empty($this->methods)) {
            $this->loadMethods();
        }

        $magicMethod = sprintf('get%sAttribute', ucwords($key));

        if (in_array($magicMethod, $this->methods)) {
            return $this->$magicMethod();
        }

        return $this->$key;
    }

    private function loadMethods(): void
    {
        $ref = new \ReflectionClass(get_class($this));
        $this->methods = array_map(fn($i) => $i->name, $ref->getMethods());
    }
}

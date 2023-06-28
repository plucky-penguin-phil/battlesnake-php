<?php

namespace Pluckypenguinphil\Battlesnake\Structs;

/**
 * @property-read string $id
 * @property-read string $name
 * @property-read int $health
 * @property-read array $body
 * @property-read string $latency
 * @property-read array $head
 * @property-read int $length
 * @property-read string $shout
 * @property-read string $squad
 * @property-read array $customizations
 */
class Snake extends Struct
{
    protected string $id;
    protected string $name;
    protected int $health;
    protected array $body;
    protected string $latency;
    protected array $head;
    protected int $length;
    protected string $shout;
    protected string $squad;
    protected array $customizations;
}

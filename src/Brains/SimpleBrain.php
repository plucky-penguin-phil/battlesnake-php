<?php

namespace Pluckypenguinphil\Battlesnake\Brains;

use Pluckypenguinphil\Battlesnake\Enums\Direction;
use Pluckypenguinphil\Battlesnake\Interfaces\IBrain;

class SimpleBrain implements IBrain
{
    public function think(): Direction
    {
        $cases = Direction::cases();
        return $cases[array_rand($cases)];
    }
}

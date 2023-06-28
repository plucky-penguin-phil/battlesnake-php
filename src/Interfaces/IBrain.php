<?php

namespace Pluckypenguinphil\Battlesnake\Interfaces;

use Pluckypenguinphil\Battlesnake\Enums\Direction;

interface IBrain
{
    public function think(): Direction;
}

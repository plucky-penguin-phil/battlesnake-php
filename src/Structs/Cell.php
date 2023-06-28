<?php

namespace Pluckypenguinphil\Battlesnake\Structs;

use Pluckypenguinphil\Battlesnake\Game;

/**
 * @property-read  int $x
 * @property-read  int $y
 * @property-read  string $id
 * @property-read \Pluckypenguinphil\Battlesnake\Structs\GameObject $contents
 * @property-read array<\Pluckypenguinphil\Battlesnake\Structs\Cell> neighbours
 *
 */
class Cell extends Struct
{
    protected int $x;
    protected int $y;
    protected GameObject $contents;

    protected function getIdAttribute(): string
    {
        return $this->x.':'.$this->y;
    }

    public function getNeighboursAttribute(): array
    {
        $neighbours = [
            'up'    => $this->tryGetNeighbourAt($this->x, $this->y + 1),
            'down'  => $this->tryGetNeighbourAt($this->x, $this->y - 1),
            'left'  => $this->tryGetNeighbourAt($this->x - 1, $this->y),
            'right' => $this->tryGetNeighbourAt($this->x + 1, $this->y),
        ];

        return array_filter($neighbours);
    }

    public function setContents(GameObject $gameObject): void
    {
        $this->contents = $gameObject;
    }

    public function __toString(): string
    {
        return $this->getIdAttribute();
    }

    /**
     * Try get the neighbouring cell at the given position.
     *
     * @param  int  $x
     * @param  int  $y
     *
     * @return \Pluckypenguinphil\Battlesnake\Structs\Cell|null
     */
    private function tryGetNeighbourAt(int $x, int $y): ?Cell
    {
        try {
            return Game::instance()->board->getCellAt($x, $y);
        } catch (\Exception) {
            return null;
        }
    }
}

<?php

namespace Pluckypenguinphil\Battlesnake\Structs;

use Pluckypenguinphil\Battlesnake\Enums\Direction;

/**
 * @prpoerty-read int $height
 * @prpoerty-read int $width
 * @prpoerty-read array $food
 * @prpoerty-read array $hazards
 * @prpoerty-read array<\Pluckypenguinphil\Battlesnake\Structs\Snake> $snakes
 */
class Board extends Struct
{
    protected int $height;
    protected int $width;
    protected array $food;
    protected array $hazards;
    protected array $snakes;
    protected array $snakeHeads;
    private array $cells;
    private array $grid;

    public function __construct(array $args)
    {
        parent::__construct($args);

        for ($i = 0, $sc = count($this->snakes); $i < $sc; $i++) {
            $this->snakes[$i] = new Snake($this->snakes[$i]);
            $this->snakeHeads[] = $this->snakes[$i]->head;
            $body = array_filter($this->snakes[$i]->body, fn($x) => $x !== $this->snakes[$i]->head);
            $this->hazards = array_merge($this->hazards, $body);
        }

        $this->cells = [];
        $this->grid = [];
    }

    /**
     * For a rebuild of the board.
     * CAUTION! this is a VERY expensive operation. Only use for debugging!
     *
     * @return void
     * @throws \Exception
     */
    public function rebuild(): void
    {
        $this->grid = [];
        for ($r = 0; $r < $this->height; $r++) {
            $row = [];
            for ($c = 0; $c < $this->width; $c++) {
                $row[] = $this->getCellAt($c, $r);
            }
            $this->grid[] = $row;
        }

        $this->grid = array_reverse($this->grid);
    }

    /**
     * Validate the given coordinates, to ensure they are within the bounds of the board.
     *
     * @param  int  $x
     * @param  int  $y
     *
     * @return bool
     */
    public function validateCoordinates(int $x, int $y): bool
    {
        return ($x >= 0 && $x < $this->width)
            && ($y >= 0 && $y < $this->height);
    }

    /**
     * Get the cell at the given coordinates.
     *
     * @param  int  $x
     * @param  int  $y
     *
     * @return \Pluckypenguinphil\Battlesnake\Structs\Cell
     * @throws \Exception
     */
    public function getCellAt(int $x, int $y): Cell
    {
        if (!$this->validateCoordinates($x, $y)) {
            throw new \Exception("Cell $x $y is out of bounds!");
        }
        $cellId = cid($x, $y);
        if (array_key_exists(cid($x, $y), $this->cells)) {
            error_log("Loading cell from cache: " . cid($x, $y), E_USER_NOTICE);
            return $this->cells[$cellId];
        }
        $this->cells[$cellId] = new Cell(['x' => $x, 'y' => $y, 'contents' => $this->getCellContents($x, $y)]);

        return $this->cells[$cellId];
    }

    /**
     * Retrieve a cell from the board by its cell id.
     *
     * @param  string  $id
     *
     * @return \Pluckypenguinphil\Battlesnake\Structs\Cell
     * @throws \Exception
     */
    public function getCellById(string $id): Cell
    {
        return $this->getCellAt(...explode(':', $id));
    }

    /**
     * Get the contents of the cell at the given coordinates.
     *
     * @param  int  $x
     * @param  int  $y
     *
     * @return \Pluckypenguinphil\Battlesnake\Structs\GameObject
     */
    public function getCellContents(int $x, int $y): GameObject
    {
        $cid = cid($x, $y);
        if (array_key_exists($cid, $this->cells)) {
            return $this->cells[$cid]->contents;
        }
        $coordinates = ['x' => $x, 'y' => $y];
        if (in_array($coordinates, $this->hazards)) {
            return GameObject::HAZARD;
        }
        if (in_array($coordinates, $this->food)) {
            return GameObject::FOOD;
        }
        if (in_array($coordinates, $this->snakeHeads)) {
            return GameObject::HEAD;
        }
        return GameObject::EMPTY;
    }

    /**
     * Get the direction to move in, from one cell to the other.
     *
     * @param  string|\Pluckypenguinphil\Battlesnake\Structs\Cell  $current
     * @param  string|\Pluckypenguinphil\Battlesnake\Structs\Cell  $next
     *
     * @return \Pluckypenguinphil\Battlesnake\Enums\Direction
     * @throws \Exception
     */
    public function getDirectionToNextCell(string|Cell $current, string|Cell $next): Direction
    {
        if (is_string($current)) {
            $current = $this->getCellById($current);
        }
        if (is_string($next)) {
            $current = $this->getCellById($next);
        }

        if ($current->x + 1 === $next->x) {
            return Direction::RIGHT;
        }
        if ($current->x - 1 === $next->x) {
            return Direction::LEFT;
        }
        if ($current->y + 1 === $next->y) {
            return Direction::UP;
        }
        if ($current->y - 1 === $next->y) {
            return Direction::DOWN;
        }

        throw new \Exception("Unable to determine direction to next cell.");
    }

    public function printBoardToLog(): void
    {
        $str = PHP_EOL;
        $this->rebuild();

        foreach ($this->grid as $row) {
            $str .= implode(
                    '',
                    array_map(function (Cell $i) {
                        return match ($i->contents) {
                            GameObject::FOOD => '⚕',
                            GameObject::HAZARD => 'H',
                            GameObject::HEAD => '■',
                            default => '.',
                        };
                    }, $row)
                ).PHP_EOL;
        }

        error_log($str, E_USER_NOTICE);
    }
}

<?php

namespace Pluckypenguinphil\Battlesnake\Brains;

use Exception;
use Pluckypenguinphil\Battlesnake\Enums\Direction;
use Pluckypenguinphil\Battlesnake\Game;
use Pluckypenguinphil\Battlesnake\Interfaces\IBrain;
use Pluckypenguinphil\Battlesnake\Structs\Cell;
use Pluckypenguinphil\Battlesnake\Structs\GameInstance;
use Pluckypenguinphil\Battlesnake\Structs\GameObject;

class HungrySnake implements IBrain
{
    private Game $gameInstance;

    public function __construct()
    {
        $this->gameInstance = Game::instance();
    }

    /**
     * @return \Pluckypenguinphil\Battlesnake\Enums\Direction
     * @throws \Exception
     */
    public function think(): Direction
    {
        $headCellId = cid(...$this->gameInstance->you->head);
        try {
            $headCell = Game::instance()->board->getCellById($headCellId);
        } catch (Exception) {
            error_log("Head cell was not found on the board. What gives? - ".$headCellId, E_USER_ERROR);
            return Direction::UP;
        }

        $reached = $this->floodFillGrid($headCellId);

        $target = $this->getClosestTarget($reached);
        if ($target === null) {
            $neighbours = $headCell->neighbours;
            try {
                return match (array_rand($neighbours, 1)) {
                    'up' => Direction::UP,
                    'down' => Direction::DOWN,
                    'left' => Direction::LEFT,
                    'right' => Direction::RIGHT
                };
            } catch (Exception) {
                // No neighbouring cells, or we are surrounded. Looks like the game's up buck-o.
                return Direction::UP;
            }
        }

        return Game::instance()->board->getDirectionToNextCell(
            $headCellId,
            $this->reconstructPath($headCellId, $target, $reached)[0]
        );
    }

    /**
     * Flood fill the grid to find the closest item of food, and the path to it.
     *
     * @param  string  $startCellId
     *
     * @return array
     */
    protected function floodFillGrid(string $startCellId): array
    {
        $frontier = [$startCellId];
        $reached = [$startCellId => null];
        while (!empty($frontier)) {
            try {
                $current = Game::instance()->board->getCellById(array_shift($frontier));
                if ($current->contents === GameObject::FOOD) {
                    error_log("FOOD found at cell ".$current, E_USER_NOTICE);
                    break;
                }
                $neighbours = array_filter($current->neighbours, function (Cell $neighbour) {
                    return $neighbour->contents !== GameObject::HAZARD
                        || ($neighbour->contents === GameObject::HEAD && $this->iAmBiggerThan($neighbour));
                });
                foreach ($neighbours as $neighbour) {
                    if (!array_key_exists($neighbour->id, $reached)) {
                        $frontier[] = $neighbour->id;
                        $reached[$neighbour->id] = $current->id;
                    }
                }
            } catch (Exception) {
                // Invalid cell was put in the frontier. Ignore it.
            }
        }
        return $reached;
    }

    /**
     * Find the closest target, and it's path.
     *
     * @param  array  $reached
     *
     * @return \Pluckypenguinphil\Battlesnake\Structs\Cell|null
     */
    protected function getClosestTarget(array $reached): ?Cell
    {
        $target = null;
        foreach ($reached as $BID => $AID) {
            try {
                $b = Game::instance()->board->getCellById($BID);
                if (
                    $b->contents === GameObject::FOOD
                    || $b->contents === GameObject::HEAD
                ) {
                    $target = $b;
                }
            } catch (Exception) {
                // Invalid cell. Move on.
            }
        }
        return $target;
    }

    /**
     * Reconstruct the path to a given cell.
     *
     * @param  string|\Pluckypenguinphil\Battlesnake\Structs\Cell  $startCellId
     * @param  string|\Pluckypenguinphil\Battlesnake\Structs\Cell  $goalCellId
     * @param  array  $steps
     *
     * @return array
     */
    private function reconstructPath(string|Cell $startCellId, string|Cell $goalCellId, array $steps): array
    {
        $path = [];
        $current = ($goalCellId instanceof Cell) ? $goalCellId->id : $goalCellId;
        if ($startCellId instanceof Cell) {
            $startCellId = $startCellId->id;
        }
        while ($current != $startCellId) {
            $path[] = Game::instance()->board->getCellById($current);
            $current = $steps[$current];
        }
        return array_reverse($path);
    }

    /**
     * Check if I am bigger than the snake sitting at the given cell.
     *
     * @param  \Pluckypenguinphil\Battlesnake\Structs\Cell  $cell
     *
     * @return bool
     */
    private function iAmBiggerThan(Cell $cell): bool
    {
        $enemySnake = Game::instance()->board->getSnakeAtPosition($cell);
        if (is_null($enemySnake)) {
            return true;
        }
        return $enemySnake->length < Game::instance()->you->length;
    }
}

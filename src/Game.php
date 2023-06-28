<?php

namespace Pluckypenguinphil\Battlesnake;

use Pluckypenguinphil\Battlesnake\Structs\Board;
use Pluckypenguinphil\Battlesnake\Structs\GameInstance;
use Pluckypenguinphil\Battlesnake\Structs\Snake;
use Pluckypenguinphil\Battlesnake\Traits\SingletonAccessor;

/**
 * @property-read ?GameInstance $gameObject
 * @property-read ?Board $board
 * @property-read ?Snake $you
 * @property-read ?int $turn
 */
class Game
{
    use SingletonAccessor;

    protected ?GameInstance $gameObject;
    protected ?Board $board;
    protected ?Snake $you;
    protected ?int $turn;

    private function __construct()
    {
        if (empty($_POST)) {
            return;
        }
        if (array_key_exists('game', $_POST)) {
            $this->gameObject = new GameInstance($_POST['game']);
        }
        if (array_key_exists('board', $_POST)) {
            $this->board = new Board($_POST['board']);
        }
        if (array_key_exists('you', $_POST)) {
            $this->you = new Snake($_POST['you']);
        }
        if (array_key_exists('turn', $_POST)) {
            $this->turn = $_POST['turn'];
        }
    }

    public function __get($key)
    {
        return $this->$key;
    }
}

<?php

namespace Pluckypenguinphil\Battlesnake;

use Pluckypenguinphil\Battlesnake\Traits\SingletonAccessor;

/**
 * @property-read $game
 * @property-read $board
 * @property-read $turn
 * @property-read $you
 * @property-read $path
 */
class Request
{
    use SingletonAccessor;

    protected $game;
    protected $board;
    protected $turn;
    protected $you;
    protected string $path;

    private function __construct()
    {
        $this->game = json_decode($_REQUEST['game'] ?? '{}', true);
        $this->board = json_decode($_REQUEST['board'] ?? '{}', true);
        $this->turn = json_decode($_REQUEST['turn'] ?? '{}', true);
        $this->you = json_decode($_REQUEST['you'] ?? '{}', true);
        $this->path = strtok($_SERVER['REQUEST_URI'], '?');
    }

    public function toArray(): array
    {
        return [
            'game'  => $this->game,
            'board' => $this->board,
            'turn'  => $this->turn,
            'you'   => $this->you,
            'path'  => $this->path,
        ];
    }

    public function __get($key)
    {
        return $this->$key;
    }
}

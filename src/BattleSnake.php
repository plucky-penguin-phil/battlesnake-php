<?php

namespace Pluckypenguinphil\Battlesnake;

use Pluckypenguinphil\Battlesnake\Interfaces\IBrain;
use Pluckypenguinphil\Battlesnake\Structs\Board;
use Pluckypenguinphil\Battlesnake\Structs\GameInstance;
use Pluckypenguinphil\Battlesnake\Structs\Response;
use Pluckypenguinphil\Battlesnake\Structs\Snake;

class BattleSnake
{
    private IBrain $brain;

    public function __construct(IBrain $brain)
    {
        $this->brain = $brain;
    }

    /**
     * Handle incoming ping request.
     *
     * @return \Pluckypenguinphil\Battlesnake\Structs\Response
     */
    public function handlePingRequest(): Response
    {
        return new Response(
            [
                'apiversion' => '1',
                'author'     => StaticSettings::instance()->snake['author' ] ?? 'PluckyPenguin',
                'color'      => StaticSettings::instance()->snake['color']   ?? '#FF0000',
                'head'       => StaticSettings::instance()->snake['head']    ?? 'lantern-fish',
                'tail'       => StaticSettings::instance()->snake['tail']    ?? 'small-rattle',
                'version'    => StaticSettings::instance()->snake['version'] ?? '1.0.0',
            ]
        );
    }

    /**
     * Handle incoming start request.
     *
     * @return \Pluckypenguinphil\Battlesnake\Structs\Response
     */
    public function handleStartRequest(): Response
    {
        return new Response(['message' => 'START']);
    }

    /**
     * Handle incoming move request.
     *
     * @return \Pluckypenguinphil\Battlesnake\Structs\Response
     */
    public function handleMoveRequest(): Response
    {
        Game::instance()->board->printBoardToLog();

        return new Response([
            'move' => $this->brain->think()->value
        ]);
    }

    /**
     * Handle incoming end request.
     *
     * @return \Pluckypenguinphil\Battlesnake\Structs\Response
     */
    public function handleEndRequest(): Response
    {
        return new Response(['message' => 'END']);
    }
}

<?php

namespace Pluckypenguinphil\Battlesnake\Structs;

use Pluckypenguinphil\Battlesnake\Enums\GameSource;
use Pluckypenguinphil\Battlesnake\Enums\Map;

/**
 * @prpoerty-read string $id
 * @prpoerty-read \Pluckypenguinphil\Battlesnake\Structs\Ruleset $ruleset
 * @prpoerty-read \Pluckypenguinphil\Battlesnake\Enums\Map $map
 * @prpoerty-read int $timeout
 * @prpoerty-read \Pluckypenguinphil\Battlesnake\Enums\GameSource $source
 */
class GameInstance extends Struct
{
    /**
     * @noinspection PhpMissingParentConstructorInspection
     * @param  array  $args
     */
    public function __construct(array $args)
    {
        $this->id = $args['id'];
        $this->ruleset = new Ruleset($args['ruleset']);
        $this->timeout = $args['timeout'];
        $this->source = match ($args['source']) {
            'tournament' => GameSource::TOURNAMENT,
            'league' => GameSource::LEAGUE,
            'arena' => GameSource::ARENA,
            'challenge' => GameSource::CHALLENGE,
            'custom' => GameSource::CUSTOM,
            default => GameSource::OTHER,
        };
    }

    /**
     * A unique identifier for this Game.Example: "totally-unique-game-id"
     *
     * @var string
     */
    protected string $id;

    /**
     * Information about the ruleset being used to run this game.
     *
     * @example {"name": "standard", "version": "v1.2.3"}
     * @var \Pluckypenguinphil\Battlesnake\Structs\Ruleset
     */
    protected Ruleset $ruleset;

    /**
     * The name of the map used to populate the game board with snakes, food, and hazards
     *
     * @example "standard"
     * @var \Pluckypenguinphil\Battlesnake\Enums\Map
     */
    protected Map $map;

    /**
     * How much time your snake has to respond to requests for this Game.
     *
     * @example 500
     * @var int
     */
    protected int $timeout;

    /**
     * The source of this game.
     *
     * @var \Pluckypenguinphil\Battlesnake\Enums\GameSource
     */
    protected GameSource $source;
}

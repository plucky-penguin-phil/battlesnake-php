<?php

namespace Pluckypenguinphil\Battlesnake\Structs;

/**
 * @property-read string $name
 * @property-read string $version
 * @property-read \Pluckypenguinphil\Battlesnake\Structs\RulesetSettings $settings
 */
class Ruleset extends Struct
{
    /**
     * Name of the ruleset being used to run this game.
     *
     * @example "solo"
     * @var string
     * @see \Pluckypenguinphil\Battlesnake\Enums\GameMode
     */
    protected string $name;

    /**
     * The release version of the ruleset being used for the game.
     *
     * @example 1.2.3
     * @var string
     */
    protected string $version;

    /**
     * A collection of specific settings being used by the current game to control how the rules are applied.
     *
     * @var \Pluckypenguinphil\Battlesnake\Structs\RulesetSettings
     */
    protected RulesetSettings $settings;

    /**
     * @noinspection PhpMissingParentConstructorInspection
     * @param  array  $args
     */
    public function __construct(array $args)
    {
        $this->name = $args['name'];
        $this->version = $args['version'];
        $this->settings = new RulesetSettings($args['settings']);
    }
}

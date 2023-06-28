<?php

namespace Pluckypenguinphil\Battlesnake\Structs;

/**
 * @property-read int $foodSpawnChance
 * @property-read int $minimumFood
 * @property-read int $hazardDamagePerTurn
 * @property-read int $royaleShrinkEveryNTurns
 * @property-read bool $squadAllowBodyCollisions
 * @property-read bool $squadShadedElimination
 * @property-read bool $squadSharedHealth
 * @property-read bool $squadSharedLength
 */
class RulesetSettings extends Struct
{
    /**
     * Percentage chance of spawning a new food every round.
     *
     * @var int
     */
    protected int $foodSpawnChance;

    /**
     *    Minimum food to keep on the board every turn.
     *
     * @var int
     */
    protected int $minimumFood;

    /**
     * Health damage a snake will take when ending its turn in a hazard.
     * This stacks on top of the regular 1 damage a snake takes per turn.
     *
     * @var int
     */
    protected int $hazardDamagePerTurn;

    /**
     * In Royale mode, the number of turns between generating new hazards (shrinking the safe board space).
     *
     * @var int
     */
    protected int $royaleShrinkEveryNTurns;

    /**
     *    In Squad mode, allow members of the same squad to move over each other without dying.
     *
     * @var bool
     */
    protected bool $squadAllowBodyCollisions;

    /**
     * In Squad mode, all squad members are eliminated when one is eliminated.
     *
     * @var bool
     */
    protected bool $squadSharedElimination;

    /**
     * In Squad mode, all squad members share health.
     *
     * @var bool
     */
    protected bool $squadSharedHealth;

    /**
     * In Squad mode, all squad members share length.
     *
     * @var bool
     */
    protected bool $squadSharedLength;
}

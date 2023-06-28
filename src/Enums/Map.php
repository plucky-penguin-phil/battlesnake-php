<?php

namespace Pluckypenguinphil\Battlesnake\Enums;

enum Map
{
    /**
     * Standard snake placement and food spawns.
     */
    case STANDARD;

    /**
     * Standard snake placement with no food spawns.
     */
    case EMPTY;

    /**
     * Arcade maze.
     */
    case ARCADE_MAZE;

    /**
     * Battle royale.
     */
    case ROYALE;

    /**
     * Solo maze where you need to find the food.
     */
    case SOLO_MAZE;

    /**
     * Inner border.
     */
    case HZ_INNER_WALL;

    /**
     * Concentric rings.
     */
    case HZ_RINGS;

    /**
     * Columns.
     */
    case HZ_COLUMNS;

    /**
     * Rivers and bridges.
     */
    case HZ_RIVERS_BRIDGES;

    /**
     * Spiral
     */
    case HZ_SPIRAL;

    /**
     * Scatter.
     */
    case HZ_SCATTER;

    /**
     * Directional expanding box.
     */
    case HZ_GROW_BOX;

    /**
     * Expanding box.
     */
    case HZ_EXPAND_BOX;

    /**
     * Expanding scatter.
     */
    case HZ_EXPAND_SCATTER;
}

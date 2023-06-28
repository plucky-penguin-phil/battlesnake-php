<?php

if (!function_exists('base_path')) {
    /**
     * Get the path to a given file from the project base directory.
     *
     * @param  string  $str
     *
     * @return string
     */
    function base_path(string $str): string
    {
        return dirname(__DIR__).DIRECTORY_SEPARATOR.$str;
    }
}

if (!function_exists('cid')) {
    /**
     * Get the ID of the cell at the given coordinates.
     *
     * @param  int  $x
     * @param  int  $y
     *
     * @return string
     */
    function cid(int $x, int $y): string
    {
        return "$x:$y";
    }
}

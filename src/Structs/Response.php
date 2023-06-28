<?php

namespace Pluckypenguinphil\Battlesnake\Structs;

/**
 * @property array $headers
 * @property string $body
 * @property int $returnCode
 */
class Response
{
    /**
     * @var array
     */
    protected array $headers = [];

    /**
     * @var string
     */
    protected string $body;

    /**
     * @var int
     */
    protected int $returnCode = 200;

    /**
     * @param  array  $body
     * @param  int  $returnCode
     * @param  array  $headers
     */
    public function __construct(array $body, int $returnCode = 200, array $headers = [])
    {
        $this->headers = $headers;
        $this->body = json_encode($body);
        $this->returnCode = $returnCode;
    }

    public function __get($key)
    {
        return $this->$key;
    }
}

<?php

require_once "../vendor/autoload.php";

$logPath = base_path('logs/'.date('Y-m-d', time()).'.log');

ini_set('log_errors', 1);
ini_set('error_log', $logPath);

use Pluckypenguinphil\Battlesnake\BattleSnake;
use Pluckypenguinphil\Battlesnake\Brains\SimpleBrain;
use Pluckypenguinphil\Battlesnake\DB;
use Pluckypenguinphil\Battlesnake\Game;
use Pluckypenguinphil\Battlesnake\StaticSettings;
use Pluckypenguinphil\Battlesnake\Structs\Response;

$_POST = json_decode(file_get_contents('php://input') ?? '{}', true);

StaticSettings::instance();
Game::instance();

$battleSnake = new BattleSnake(new \Pluckypenguinphil\Battlesnake\Brains\HungrySnake());

$path = strtok($_SERVER['REQUEST_URI'], '?');

error_log("Processing incoming request ".$path, E_USER_NOTICE);

$result = match ($path) {
    '/start' => $battleSnake->handleStartRequest(),
    '/move' => $battleSnake->handleMoveRequest(),
    '/end' => $battleSnake->handleEndRequest(),
    default => $battleSnake->handlePingRequest(),
};

$headers = $result->headers;
if (!array_key_exists('content-type', $headers)) {
    $headers['content-type'] = 'application/json';
}

foreach ($headers as $key => $value) {
    header(sprintf('%s:%s', $key, $value));
}

http_response_code($result->returnCode);

echo $result->body;


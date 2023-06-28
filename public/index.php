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

/**
 * Handle the script shutdown process.
 *
 * @param  string  $path
 * @param  \Pluckypenguinphil\Battlesnake\Structs\Response  $result
 *
 * @return void
 */
function handleShutdown(string $path, Response $result): void
{
    $snake = json_decode($_REQUEST['you'] ?? '{}', true);
    $data = [
        'snake_id'   => $snake ? $snake['id'] : null,
        'route'      => $path,
        'request'    => json_encode($_REQUEST),
        'response'   => $result->body,
        'created_at' => date('Y-m-d H:i:s', time()),
    ];
    DB::pdo()->prepare(
        "INSERT INTO requests(snake_id,route,request,response,created_at) VALUES(:snake_id,:route,:request,:response,:created_at)"
    )
        ->execute($data);
}

register_shutdown_function(fn() => handleShutdown($path, $result));

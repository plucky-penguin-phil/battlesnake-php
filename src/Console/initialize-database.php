<?php

use Pluckypenguinphil\Battlesnake\DB;

require_once(dirname(__DIR__, 2).'/vendor/autoload.php');

ini_set('log_errors', 1);
ini_set('error_log', base_path('logs/'.date('Y-m-d', time()).'.log'));

echo "Creating table schema...".PHP_EOL;

$sql = <<<SQL
CREATE TABLE IF NOT EXISTS `requests`(
    `id` INT NOT NULL AUTO_INCREMENT,
    `snake_id` VARCHAR(100),
    `route` varchar(255) not null,
    `request` TEXT,
    `response` TEXT,
    `created_at` DATETIME default CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
)
SQL;

try {
    DB::pdo()->exec($sql);
} catch (\PDOException $e) {
    echo "Failed to create table schema. Reason: ".$e->getMessage();
}

echo "Completed.".PHP_EOL;

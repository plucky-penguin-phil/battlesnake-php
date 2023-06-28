<?php

namespace Pluckypenguinphil\Battlesnake;

use \PDO;
use PDOException;
use Pluckypenguinphil\Battlesnake\Traits\SingletonAccessor;

class DB
{
    private static ?PDO $pdo = null;

    private function __construct()
    {
    }

    /**
     * Get the current PDO instance.
     *
     * @return \PDO
     */
    public static function pdo(): PDO
    {
        if (self::$pdo === null) {
            self::initPDO();
        }
        return self::$pdo;
    }

    /**
     * Initialize the PDO connection.
     *
     * @return void
     */
    private static function initPDO(): void
    {
        try {
            self::$pdo = new PDO(
                sprintf(
                    "mysql:host=%s;dbname=%s",
                    StaticSettings::instance()->database['host'],
                    StaticSettings::instance()->database['database']
                ),
                StaticSettings::instance()->database['username'],
                StaticSettings::instance()->database['password'],
                [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                ]
            );
        } catch (PDOException $e) {
            die("Failed to connect to database. Reason: ".$e->getMessage());
        }
    }
}

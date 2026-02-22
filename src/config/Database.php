<?php
namespace config;

class Database {
    private static $pdo = null;

    public static function get() {
        if (self::$pdo === null) {
            self::$pdo = new \PDO(
                'mysql:host=localhost;dbname=cinema_min;charset=utf8mb4',
                'root', '',
                [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
            );
        }
        return self::$pdo;
    }
}
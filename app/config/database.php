<?php
class Database {
    private static $host = "localhost";
    private static $db_name = "my_store";
    private static $username = "root";
    private static $password = "";
    
    public static function getConnection() {
        $conn = null;
        try {
            $conn = new PDO(
                "mysql:host=" . self::$host . ";port=3307;dbname=" . self::$db_name,
                self::$username,
                self::$password
            );
        $conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $conn;
    }
}
<?php
class Database
{
    private static $pdo;

    public static function getConnection()
    {
        if (self::$pdo === null) {
            $host = 'localhost';
            $db = 'geovendas'; 
            $user = 'root';
            $password = '';

            try {
                self::$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro de conexão: " . $e->getMessage());
            }
        }

        return self::$pdo;
    }
}
?>

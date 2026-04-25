<?php
class Database
{
    private static ?Database $instance = null;
    private PDO $pdo;

    private function __construct()
    {
        $host = 'mysql-chalendard-remy13.alwaysdata.net'; 
        $user = 'chalendard-remy13';                       
        $password = 'aitanaMars13!';                   
        $database = 'chalendard-remy13_travelinseoul';    

        try {
            $this->pdo = new PDO(
                "mysql:host=$host;dbname=$database;charset=utf8mb4",
                $user,
                $password
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getPDO(): PDO
    {
        return $this->pdo;
    }

    private function __clone() {}

    public function __wakeup()
    {
        throw new Exception("Cannot unserialize a singleton");
    }
    
}

define('BASE_URL', $_ENV['BASE_URL'] ?? '');

function image_url($path)
{
    return BASE_URL . '/' . ltrim($path, '/');
}

<?php

// $host = "mysql-server";       
// $user = "root";            
// $password = "root";            
// $database = "travelinseoul"; 

// try {
//     $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $user, $password);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (PDOException $e) {
//     die("Erreur de connexion : " . $e->getMessage());
// }


class Database {
    private static ?Database $instance = null;
    private PDO $pdo;
    
    // Constructeur privé (empêche new Database())
    private function __construct() {
        $host = "mysql-server";       
        $user = "root";            
        $password = "root";            
        $database = "travelinseoul"; 

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
    
    // Méthode statique pour obtenir l'instance unique
    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    
    // Retourner l'objet PDO
    public function getPDO(): PDO {
        return $this->pdo;
    }
    
    // Empêcher le clonage
    private function __clone() {}
    
    // Empêcher la désérialisation
    public function __wakeup() {
        throw new Exception("Cannot unserialize a singleton");
    }
}


?>
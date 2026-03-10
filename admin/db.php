<?php


if (!isset($_ENV)) {
    die("Erreur : impossible de lire le fichier .env");
}

$host =$_ENV;   
$dbname = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];      
$password = $_ENV['DB_PASSWORD'];

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
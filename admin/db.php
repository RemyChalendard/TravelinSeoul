<?php

if (!isset($_ENV['DB_HOST'])) {
    die("Erreur : impossible de lire les variables d'environnement");
}

$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_DATABASE'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];

try {
$pdo = new PDO(
    "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
    $user,
    $pass,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
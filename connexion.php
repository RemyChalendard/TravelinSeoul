<?php
$host = 'mysql-server';
$dbname = 'travelinseoul';
$user = 'root';
$pass = 'root';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $user,
        $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("<p style='color:red'>Connexion échouée : " . $e->getMessage() . "</p>");
}
?>
<?php
$envPath = "/var/www/html/travelInSeoul/.env";

$env = parse_ini_file($envPath);

if ($env === false) {
    die("Erreur : impossible de lire le fichier .env");
}

$host = $env['DB_HOST'];   
$dbname = $env['DB_NAME'];
$user = $env['DB_USER'];      
$password = $env['DB_PASSWORD'];

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
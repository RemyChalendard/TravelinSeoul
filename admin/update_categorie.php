<?php
session_start();
require_once __DIR__ . "/db.php";

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $id = $_POST['id'] ?? '';
    $categorie = $_POST['categorie'] ?? '';
    
    $stmt = $pdo->prepare("UPDATE articles SET categorie = :categorie WHERE id = :id");
    $stmt->execute([
        ':categorie' => $categorie,
        ':id' => $id
    ]);
}

header("Location: dashboard.php");
exit;
?>
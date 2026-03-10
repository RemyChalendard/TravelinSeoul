<?php
session_start();
require_once __DIR__ . "/db.php";

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $id = $_POST['id'] ?? '';
    $etat = $_POST['etat'] ?? '';
    
    if(!$id || !$etat){
        header("Location: dashboard.php?error=donnees_manquantes");
        exit;
    }
    
    $stmt = $pdo->prepare("UPDATE articles SET etat = :etat WHERE id = :id");
    $stmt->execute([
        ':etat' => $etat,
        ':id' => $id
    ]);
}

header("Location: dashboard.php");
exit;
?>
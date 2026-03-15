<?php
session_start();
require_once "db.php";

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $id = $_POST['id'] ?? '';
    $contenu = $_POST['contenu'] ?? '';
    
    if(!empty($id) && !empty($contenu)){
        try {
            $stmt = $pdo->prepare("UPDATE article SET content = :contenu WHERE id = :id");
            $stmt->execute([
                ':contenu' => $contenu,
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            die("Erreur : " . $e->getMessage());
        }
    }
}

header("Location: dashboard.php");
exit;
?>
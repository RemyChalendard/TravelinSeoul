<?php
session_start();
require_once "db.php";

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? '';

if(!empty($id)){
    try {
        $stmt = $pdo->prepare("DELETE FROM articles WHERE id = :id");
        $stmt->execute([':id' => $id]);
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
}

header("Location: dashboard.php");
exit;
?>
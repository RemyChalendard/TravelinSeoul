<?php
session_start();
require_once __DIR__ . "/db.php";

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['images'])){
    $id = $_POST['id'] ?? '';
    $photo = $_FILES['images'];
    
    $upload_dir = "../images/";
    if(!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
    
    $filename = uniqid() . "_" . basename($photo['name']);
    $filepath = $upload_dir . $filename;
    
    $allowed = ['images/jpeg', 'images/png', 'images/gif', 'images/webp'];
    if(!in_array($photo['type'], $allowed)){
        header("Location: dashboard.php?error=format");
        exit;
    }
    
    if(move_uploaded_file($photo['tmp_name'], $filepath)){
        $stmt = $pdo->prepare("UPDATE articles SET photo = :images WHERE id = :id");
        $stmt->execute([
            ':images' => $filename,
            ':id' => $id
        ]);
        header("Location: dashboard.php?success=photo");
    } else {
        header("Location: dashboard.php?error=upload");
    }
    exit;
}

header("Location: dashboard.php");
exit;
?>
<?php
session_start();
require_once __DIR__ . "/db.php";

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo'])){
    $id = $_POST['id'] ?? '';
    $photo = $_FILES['photo'];
    
    $upload_dir = "../images/";
    if(!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
    
    $filename = basename($photo['name']);
    $filepath = $upload_dir . $filename;
    
    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/avif'];
    if(!in_array($photo['type'], $allowed)){
        header("Location: dashboard.php");
        exit;
    }
    
    if(move_uploaded_file($photo['tmp_name'], $filepath)){
        $stmt = $pdo->prepare("UPDATE articles SET image = :image WHERE id = :id");
        $stmt->execute([
            ':image' => 'images/' . $filename,
            ':id' => $id
        ]);
        header("Location: dashboard.php");
    } else {
        header("Location: dashboard.php");
    }
    exit;
}


header("Location: dashboard.php");
exit;
?>
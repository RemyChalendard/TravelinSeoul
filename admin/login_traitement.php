<?php
session_start();
require_once __DIR__ . "/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        header("Location: login.php?error=empty");
        exit;
    }
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $admin = $stmt->fetch();
        
        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin'] = $admin['id'];
            header("Location: dashboard.php");
            exit;
        } else {
            header("Location: login.php?error=1");
            exit;
        }
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
}
?>
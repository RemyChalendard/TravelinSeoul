<?php
session_start();
require_once __DIR__ . "/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    echo "Username: " . $username . "<br>";
    echo "Password: " . $password . "<br>";
    
    if (empty($username) || empty($password)) {
        echo "Identifiants vides";
        exit;
    }
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $admin = $stmt->fetch();
        
        echo "Admin trouvé: " . ($admin ? "OUI" : "NON") . "<br>";
        
        if ($admin) {
            echo "Hash BD: " . $admin['password'] . "<br>";
            echo "Vérification: " . (password_verify($password, $admin['password']) ? "OK" : "FAIL") . "<br>";
        }
        
        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin'] = $admin['id'];
            echo "Redirection...";
            header("Location: dashboard.php");
            exit;
        } else {
            echo "Identifiant ou mot de passe incorrect";
            exit;
        }
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
}
?>
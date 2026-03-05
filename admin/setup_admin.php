<?php
require_once __DIR__ . "/admin/db.php";

$username = "remychalendard";
$password = "aitanaMars13013!";
$hashed = password_hash($password, PASSWORD_BCRYPT);

echo "Hash: " . $hashed . "<br>";

// Supprimer l'ancien admin s'il existe
$pdo->exec("DELETE FROM admins WHERE username = 'remychalendard'");

// Insérer le nouveau
$stmt = $pdo->prepare("INSERT INTO admins (username, password) VALUES (:username, :password)");
$stmt->execute([
    ':username' => $username,
    ':password' => $hashed
]);

echo "Admin créé avec le hash ci-dessus !<br>";

// Vérifier
$stmt = $pdo->prepare("SELECT * FROM admins WHERE username = :username");
$stmt->execute([':username' => $username]);
$admin = $stmt->fetch();
echo "Vérification: " . (password_verify($password, $admin['password']) ? "✅ OK" : "❌ FAIL") . "<br>";
?>
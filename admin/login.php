<?php
session_start();
require_once __DIR__ . "/db.php";

if(isset($_SESSION['admin'])){
    header("Location: dashboard.php");
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Connexion Admin</title>
<link rel="stylesheet" href="/travelInSeoul/styles/admin.css">
</head>
<body>

<div class="login-container">
<h2>Connexion Administrateur</h2>
<form action="login_traitement.php" method="POST">

    <label>Identifiant</label>
    <input type="text" name="username" required>
    <label>Mot de passe</label>
    <input type="password" name="password" required>
    <button type="submit">Se connecter</button>
</form>
</div>

</body>
</html>
<?php include "footer.php"; ?>
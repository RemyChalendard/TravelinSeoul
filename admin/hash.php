<?php
$password = "aitanaMars13013!";
$hash = password_hash($password, PASSWORD_BCRYPT);
echo "Hash: " . $hash . "<br>";
echo "Longueur: " . strlen($hash) . " caractères";
?>
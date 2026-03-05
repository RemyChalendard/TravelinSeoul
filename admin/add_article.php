<?php
require_once("../admin/db.php");  
include "../admin/header.php";      
?>


<?php
session_start();
require 'db.php';

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
}

$titre = $_POST['titre'];
$contenu = $_POST['contenu'];

$sql = $pdo->prepare("INSERT INTO articles (titre, contenu) VALUES (?,?)");
$sql->execute([$titre,$contenu]);

header("Location: dashboard.php");
?>

<?php include "footer.php"; ?>
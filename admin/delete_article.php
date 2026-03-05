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

$id = $_GET['id'];

$sql = $pdo->prepare("DELETE FROM articles WHERE id=?");
$sql->execute([$id]);

header("Location: dashboard.php");
?>

<?php include "footer.php"; ?>
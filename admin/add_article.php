<?php
session_start();
require_once __DIR__ . "/db.php";

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

header("Location: dashboard.php");
exit;
?>
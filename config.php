<?php


$host = "localhost";       
$user = "root";            
$password = "";            
$database = "travelinseoul"; 


$mysqli = new mysqli($host, $user, $password, $database);

if ($mysqli->connect_error) {
    die("Erreur de connexion à la base de données: " . $mysqli->connect_error);
}


$mysqli->set_charset("utf8mb4");


mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

?>
<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "login"; // Remplacez par le nom de votre base

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connexion échouée: " . mysqli_connect_error());
}
?>
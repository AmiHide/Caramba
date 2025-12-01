<?php

// Notre config de la BDD
$host = "localhost";
$dbname = "caramba";
$username = "root";
$password = "";

// Connexion PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch (Exception $e) {
    die("Erreur connexion : " . $e->getMessage());
}

<?php

// 1. On définit le chemin vers le fichier .env
$envFile = __DIR__ . '/../.env';

// 2. On charge les variables si le fichier existe
if (file_exists($envFile)) {
    // parse_ini_file lit le fichier comme un dictionnaire (array associatif)
    $env = parse_ini_file($envFile);
} else {
    // Gestion d'erreur si le fichier est introuvable
    die("Erreur : Le fichier .env est introuvable.");
}

// 3. Notre config de la BDD en utilisant les variables du .env
// On utilise l'opérateur '??' pour mettre une valeur par défaut si la clé manque
$host = $env['DB_HOST'] ?? "localhost";
$dbname = $env['DB_NAME'] ?? "Caramba";
$username = $env['DB_USER'] ?? "root";
$password = $env['DB_PASSWORD'] ?? "";
$charset = 'utf8mb4';

// Notre config de la BDD
$host = "localhost";

$dbname = "Caramba";
$username = "root";
$password = "";
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset"; 

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// Connexion PDO
try {
     $pdo = new PDO($dsn, $username, $password, $options); 
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>

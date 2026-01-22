<?php

// Notre config de la BDD
$host = $_ENV['DB_HOST'] ?? getenv('DB_HOST');
$dbname = $_ENV['DB_NAME'] ?? getenv('DB_NAME');
$username = $_ENV['DB_USER'] ?? getenv('DB_USER');
$password = $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD');
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=3306;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// Connexion PDO
try {
     $pdo = new PDO($dsn, $username, $password, $options); 
} 
catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>

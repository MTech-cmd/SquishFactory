<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Load the .env file
$dotenv = Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

// Verander waarbij nodig
$servername = $_ENV['PMA_HOST'];
$port;
$username = $_ENV['MYSQL_USER'];
$password = $_ENV['MYSQL_PASSWORD'];
$database = $_ENV['MYSQL_DATABASE'];

$prep = (!empty($port)) ? "mysql:host=$servername;port=$port;dbname=$database" : "mysql:host=$servername;dbname=$database";

try {
    $pdo = new PDO($prep, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

function bindparams($query, $params) 
{
    foreach ($params as $placeholder => &$param) {
        $query->bindParam($placeholder, $param);
    }
}

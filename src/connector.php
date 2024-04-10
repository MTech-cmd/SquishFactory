<?php

// Verander waarbij nodig
$servername = "localhost";
$port;
$username = "bit_academy";
$password = "bit_academy";
$database = "SquishFactory";

$prep = (!empty($port)) ? "mysql:host=$servername;port=$port;dbname=$database" : "mysql:host=$servername;dbname=$database";

try {
    $pdo = new PDO($prep, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
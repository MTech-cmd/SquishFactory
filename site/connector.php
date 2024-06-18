<?php

// Verander waarbij nodig
$servername = "db";
$port = "3306";
$username = "bit_academy";
$password = "bit_academy";
$database = "SquishFactory";

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
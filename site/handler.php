<?php

session_start();

if (!isset($_SESSION['UserID'])) {
    header("Location: require_login.html");
    die();
}

require 'connector.php';

$sql = "UPDATE Orders SET Status = 'Accepted' WHERE Status = 'Pending' AND UserID = ?";
$query = $pdo->prepare($sql);
$query->execute([$_SESSION['UserID']]);
header("Location: orders.php");
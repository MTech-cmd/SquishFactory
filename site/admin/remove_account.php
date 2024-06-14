<?php

require "connector.php";

try {
    $sql = "DELETE FROM Users WHERE UserID = ?";
    $query = $pdo->prepare($sql);
    $query->execute([$_GET['id']]);
    header("Location: accounts.php");
    die();
} catch (PDOException $e) {
    header("Location: no_delete.html");
    die();
}
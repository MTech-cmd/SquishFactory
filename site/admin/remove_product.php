<?php

// TODO: Merge with remove accessory
session_start();
if (!isset($_SESSION['AdminID'])) {
    header("Location: login.php");
    die;
}

require "../connector.php";

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if ($_GET['type'] === 'mellow') {
        $type = "Mellows";
        $typeid = "ProductID";
    } else {
        $type = "Accessories";
        $typeid = "AccessoryID";
    }
    // Check if the product exists
    $sql = "SELECT * FROM {$type} WHERE {$typeid} = :id";
    $query = $pdo->prepare($sql);
    $query->bindParam(':id', $_GET['id']);
    $query->execute();
    $product = $query->fetch();

    if (!$product) {
        $_SESSION['error'] = "Product not found";
        header("Location: products.php");
        die;
    }

    // Delete the product from the database
    $sql = "DELETE FROM {$type} WHERE {$typeid} = :id";
    $query = $pdo->prepare($sql);
    $query->bindParam(':id', $_GET['id']);
    $query->execute();

    // Delete the product image if it exists
    if (file_exists($product['Filepath'])) {
        unlink($product['Filepath']);
    }

    $_SESSION['success'] = "Product deleted successfully";
    header("Location: products.php");
    die;
} else {
    $_SESSION['error'] = "Invalid request";
    header("Location: products.php");
    die;
}
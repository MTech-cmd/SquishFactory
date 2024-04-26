<?php
session_start();
if (!isset($_SESSION['AdminID'])) {
    header("Location: login.php");
    die;
}

require "../connector.php";

if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['id'])) {
    $productID = $_GET['id'];

    // Check if the product exists
    $sql = "SELECT * FROM Mellows WHERE ProductID = :id";
    $query = $pdo->prepare($sql);
    $query->bindParam(':id', $productID);
    $query->execute();
    $product = $query->fetch();

    if (!$product) {
        $_SESSION['error'] = "Product not found";
        header("Location: products.php");
        die;
    }

    // Delete the product from the database
    $sql = "DELETE FROM Mellows WHERE ProductID = :id";
    $query = $pdo->prepare($sql);
    $query->bindParam(':id', $productID);
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
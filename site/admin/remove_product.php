<?php

session_start();
if (!isset($_SESSION['AdminID'])) {
    header("Location: login.php");
    die;
}

require "../connector.php";

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    switch ($_GET['type']) {
        case 'mellow':
            $type = "Mellows";
            $typeid = "ProductID";
            $location = "Location: products.php";
            break;
        case 'accessory':
            $type = "Accessories";
            $typeid = "AccessoryID";
            $location = "Location: products.php";
            break;
        case 'pilot':
            $type = "Examples";
            $typeid = "ExampleID";
            $location = "Location: pilot.php";
            break;
        case 'coupon':
            $type = "Coupons";
            $typeid = "CouponID";
            $location = "Location: coupons.php";
            break;
        default:
            $location = "Location: products.php";
            break;
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
    $targetFile = "..{$product['Filepath']}";
    if (file_exists($targetFile)) {
        unlink($targetFile);
    }
        $_SESSION['success'] = "Product deleted successfully";
        header($location);
    die;
} else {
    $_SESSION['error'] = "Invalid request";
    header($location);
    die;
}

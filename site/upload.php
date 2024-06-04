<?php

require "connector.php";

session_start();
function extractPath($url)
{
    $parsed_url = parse_url($url, PHP_URL_PATH);
    $position = strpos($parsed_url, "/site");
    return substr($parsed_url, $position + strlen("/site"));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $path = extractPath($_POST['path']);
    $sqlPrice = "SELECT Price FROM Accessories WHERE Filepath = :path";
    $queryPrice = $pdo->prepare($sqlPrice);
    $queryPrice->bindParam(':path', $path);
    $queryPrice->execute();
    $price = 1000 + $queryPrice->fetch(PDO::FETCH_NUM)[0]; // Base is always €10

    $uploadDir = "./assets/cart/";
    $targetFile = $uploadDir . uniqid('img_', true) . '.png';
    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile) && isset($_SESSION['UserID'])) {
        $sql = "INSERT INTO Mellows (Price, Custom, Filepath) VALUES (:price, 0, :img)";
        $query = $pdo->prepare($sql);
        $query->bindParam(':price', $price);
        $targetFile = substr($targetFile, 1);
        $query->bindParam(':img', $targetFile);
        $query->execute();
        $productId = $pdo->lastInsertId();

        $sqlCart = "INSERT INTO Cart (UserID, ProductID) VALUES (:user, :product)";
        $queryCart = $pdo->prepare($sqlCart);
        $queryCart->bindParam(':user', $_SESSION['UserID']);
        $queryCart->bindParam(':product', $productId);
        $queryCart->execute();
    }
}
?>

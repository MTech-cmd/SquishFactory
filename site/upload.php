<?php

require "connector.php";
session_start();
// Ensure the script is receiving a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the isAdmin flag
    $isAdmin = isset($_POST['isAdmin']) ? filter_var($_POST['isAdmin'], FILTER_VALIDATE_BOOLEAN) : false;
    // Check if the file was uploaded without any errors
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Define the directory where the file will be uploaded
        if ($isAdmin) {
            $uploadDir = "assets/landing/";
            $sql = "INSERT INTO Examples (Filepath, AdminID) VALUES (:img, :id)";
            $query = $pdo->prepare($sql);
            $query->bindParam(':id', $_SESSION['AdminID']);
        } else {
            $uploadDir = "assets/cart/";
            $sql = "INSERT INTO Mellows (Custom, Filepath) VALUES (:custom, :img)";
            $query = $pdo->prepare($sql);
            $query->bindParam(':custom', 0);
        }

        // Generate a unique name for the uploaded file
        $targetFile = $uploadDir . uniqid('img_', true) . '.png';

        // Move the uploaded file to the destination directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $query->bindParam(':img', $targetFile);
            $query->execute();

            if (!$isAdmin) {
                $mellowId = $pdo->lastInsertId();
                $sqlCart = "INSERT INTO Cart (UserID, ProductID) VALUES (:user, :mellow)";
                $queryCart->prepare($sqlCart);
                $queryCart->bindParam(':user', $_SESSION['UserID']);
                $queryCart->bindParam(':mellow', $mellowId);
            }
        }
    }
}
?>
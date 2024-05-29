<?php

require "connector.php";
session_start();
// Ensure the script is receiving a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the file was uploaded without any errors
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Define the directory where the file will be uploaded
            $uploadDir = "../assets/landing/";
            $sql = "INSERT INTO Examples (Filepath, AdminID) VALUES (:img, :id)";
            $query = $pdo->prepare($sql);
            $query->bindParam(':id', $_SESSION['AdminID']);

        // Generate a unique name for the uploaded file
        $targetFile = $uploadDir . uniqid('img_', true) . '.png';

        // Move the uploaded file to the destination directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $targetFile = substr($targetFile, 2);
            $query->bindParam(':img', $targetFile);
            $query->execute();
        }
    }
}
?>

<?php

require "connector.php";
// Ensure the script is receiving a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the isAdmin flag
    $isAdmin = isset($_POST['isAdmin']) ? filter_var($_POST['isAdmin'], FILTER_VALIDATE_BOOLEAN) : false;
    // Check if the file was uploaded without any errors
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Define the directory where the file will be uploaded
        if ($isAdmin) {
            $uploadDir = "assets/landing/";
        } else {
            $uploadDir = "assets/cart";
        }

        // Generate a unique name for the uploaded file
        $uploadFile = $uploadDir . uniqid('img_', true) . '.png';

        // Move the uploaded file to the destination directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
        }
    }
}
?>

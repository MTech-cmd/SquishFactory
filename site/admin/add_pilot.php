<?php

require "../connector.php";
session_start();
if (!isset($_SESSION['skillissue'])) {
    $_SESSION['skillissue'] = null;
}

if (!isset($_SESSION['AdminID'])) {
    header("Location: login.php");
    die;
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (empty($_FILES['image'])) {
        $_SESSION['skillissue'] = "allfields";
    } else {
        $_SESSION['skillissue'] = null;
        $supportedTypes =  array('image/png', 'image/jpg', 'image/jpeg', 'image/gif');
        $maxFileSize = 50 * 1024 * 1024; // 50MB
        $targetDir = "../assets/landing/";
        $targetFile = $targetDir . uniqid() . "_" . basename($_FILES['image']['name']);
        if (!in_array($_FILES['image']['type'], $supportedTypes)) {
            $_SESSION['skillissue'] = "filetype";
            header("Location: add_pilot.php");
            die;
        }
        if ($_FILES['image']['size'] > $maxFileSize) {
            $_SESSION['skillissue'] = "filesize";
            header("Location: add_pilot.php");
            die;
        }
        move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
        
        $sql = "INSERT INTO Examples (Filepath, AdminID) VALUES (:image, :id)";
        $query = $pdo->prepare($sql);
        $targetFile = substr($targetFile, 2);
        $query->bindParam(':image', $targetFile);
        $query->bindParam(':id', $_SESSION['AdminID'], PDO::PARAM_INT);
        $query->execute();

        header("Location: pilot.php");
        die;
    }
}

include "head.php";
?>

<body class="container mt-3">
    <form action="add_pilot.php" method="POST" enctype="multipart/form-data">
        <div>
            <label for="image" class="form-label">Image:</label>
            <input type="file" class="form-control" id="image" name="image">
            <div class="alert alert-warning mt-2">
                <p class="mb-0">A standard Pilot Mellow's picture size is 450x600. It is advised to use this ratio.</p>
            </div>
            <?php switch ($_SESSION['skillissue']) { 
                case "allfields": 
                    ?>
            <div class="alert alert-danger mt-2">
                <p class="text-white mb-0">Please upload an image</p>
            </div>
                    <?php 
                    break;
                case "filetype":
                    ?>
            <div class="alert alert-danger mt-2">
                <p class="text-white mb-0">Please upload a valid image file</p>
            </div>
                    <?php
                    break;
                case "filesize":
                    ?>
            <div class="alert alert-danger mt-2">
                <p class="text-white mb-0">Please upload a file smaller than 50MB</p>
            </div>
                    <?php
                    break;
                default:
                    break;
            } ?>
        </div>
        <div class="mt-2">
            <button type="submit" class="btn btn-outline-success">Upload</button>
            <a href="pilot.php" class="btn btn-outline-primary"><i class="fas fa-arrow-left"></i> Go Back</a>
        </div>

    </form>

</body>

<?php

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    header("Location: add_pilot.php");
    die;
}
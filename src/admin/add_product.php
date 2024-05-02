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
    $name = htmlspecialchars($_POST['name']);
    $price = intval(htmlspecialchars($_POST['price']));

    if (empty($_POST['name']) || empty($_POST['price']) || empty($_POST['type']) || empty($_FILES['image'])) {
        $_SESSION['skillissue'] = "allfields";
    } else {
        $_SESSION['skillissue'] = null;
        $supportedTypes =  array('image/png', 'image/jpg', 'image/jpeg', 'image/gif');
        $maxFileSize = 50 * 1024 * 1024; // 50MB
        if ($_POST['type'] === "Mellow") {
            $targetDir = "../assets/custom-mellows/";
            $type = "Mellows";
        } else {
            $targetDir = "../assets/accessories/";
            $type = "Accessories";
        }
        $targetFile = $targetDir . uniqid() . "_" . basename($_FILES['image']['name']);
        if (!in_array($_FILES['image']['type'], $supportedTypes)) {
            $_SESSION['skillissue'] = "filetype";
            header("Location: add_product.php");
            die;
        }
        if ($_FILES['image']['size'] > $maxFileSize) {
            $_SESSION['skillissue'] = "filesize";
            header("Location: add_product.php");
            die;
        }
        move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
        
        $sql = "INSERT INTO {$type} (Name, Price, Filepath) VALUES (:name, :price, :image)";
        $query = $pdo->prepare($sql);
        $query->bindParam(':name', $name);
        $query->bindParam(':price', $price, PDO::PARAM_INT);
        $query->bindParam(':image', $targetFile);
        $query->execute();

        header("Location: products.php");
        die;
    }
}

include "head.php";
?>

<body class="container mt-3">
    <form action="add_product.php" method="POST" enctype="multipart/form-data">
        <div>
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" name="name" maxlength="60">
        </div>
        <div>
            <label for="price" class="form-label">Price (Eurocent):</label>
            <input type="number" class="form-control" id="price" name="price">
        </div>
        <div>
            <label for="type" class="form-label">Type:</label>
            <select class="form-select" id="type" name="type">
                <option>Mellow</option>
                <option>Accessory</option>
            </select>
        </div>
        <div>
            <label for="image" class="form-label">Image:</label>
            <input type="file" class="form-control" id="image" name="image">
            <div class="alert alert-warning mt-2">
                <p class="mb-0">A standard Mellow's picture size is 1340x1560. It is advised to use this ratio.</p>
            </div>
            <?php switch ($_SESSION['skillissue']) { 
                case "allfields": 
                    ?>
            <div class="alert alert-danger mt-2">
                <p class="text-white mb-0">Please fill in all fields</p>
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
            <a href="products.php" class="btn btn-outline-primary"><i class="fas fa-arrow-left"></i> Go Back</a>
        </div>

    </form>

</body>

<?php

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    header("Location: add_product.php");
    die;
}
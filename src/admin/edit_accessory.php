<?php

session_start();
if (!isset($_SESSION['AdminID'])) {
    header("Location: login.php");
    die;
}

require "../connector.php";

$sql = "SELECT * FROM Mellows WHERE ProductID = :id";
$query = $pdo->prepare($sql);
$query->bindParam(':id', $_GET['id']);
$query->execute();
$mellow = $query->fetch();

$euro = substr($mellow['Price'], 0, -2);
$cent = substr($mellow['Price'], -2);
$price = $euro . "." . $cent;

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (empty($_POST['name']) || empty($_POST['price'])) {
        $_SESSION['skillissue'] = "allfields";
        header("Location: edit_product.php?id=" . $_GET['id']);
        die;
    }

    $price = str_replace(".", "", $_POST['price']);

    // Check if a file was uploaded
    if (!empty($_FILES['image']['name'])) {
        // File was uploaded, process it
        if ($_FILES['image']['size'] > 50000000) {
            $_SESSION['skillissue'] = "filesize";
            header("Location: edit_product.php?id=" . $_GET['id']);
            die;
        }

        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filetype = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        if (!in_array($filetype, $allowed)) {
            $_SESSION['skillissue'] = "filetype";
            header("Location: edit_product.php?id=" . $_GET['id']);
            die;
        }

        $filename = "../assets/custom-mellows/" . uniqid() . "." . $filetype;
        move_uploaded_file($_FILES['image']['tmp_name'], $filename);

        // Update the filepath in the database
        $sql = "UPDATE Mellows SET Filepath = :filepath WHERE ProductID = :id";
        $query = $pdo->prepare($sql);
        $query->bindParam(':filepath', $filename);
        $query->bindParam(':id', $_GET['id']);
        $query->execute();
    }

    // Update other fields in the database
    $sql = "UPDATE Mellows SET Name = :name, Price = :price WHERE ProductID = :id";
    $query = $pdo->prepare($sql);
    $query->bindParam(':name', $_POST['name']);
    $query->bindParam(':price', $price);
    $query->bindParam(':id', $_GET['id']);
    $query->execute();

    header("Location: products.php");
    die;
}

include "head.php";
?>

<body class="container mt-3">
    <form action="edit_product.php?id=<?= $_GET['id'] ?>" method="POST" enctype="multipart/form-data">
        <div>
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" name="name" maxlength="60" value="<?= $mellow['Name'] ?>">
        </div>
        <div>
            <label for="price" class="form-label">Price (Eurocent):</label>
            <input type="number" class="form-control" id="price" name="price" value="<?= $price ?>">
        </div>
        <div>
            <label for="image" class="form-label">Edit Picture:</label>
            <input type="file" class="form-control" id="image" name="image">
            <div class="alert alert-warning mt-2">
                <p class="mb-0">A standard Mellow's picture size is 1340x1560. It is advised to use this ratio.</p>
            </div>
            <?php if (isset($_SESSION['skillissue'])) {
                switch ($_SESSION['skillissue']) {
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
                }
                unset($_SESSION['skillissue']);
            } ?>
        </div>
        <img src="<?= $mellow['Filepath'] ?>" alt="Product Image" class="img-fluid mt-2" style="max-width: 100px;">
        <div class="mt-2">
            <button type="submit" class="btn btn-outline-success">Edit</button>
            <a href="remove_product.php?id=<?= $mellow['ProductID'] ?>" class="btn btn-outline-danger"><i
                    class="fas fa-trash"></i> Delete</a>
            <a href="products.php" class="btn btn-outline-primary"><i class="fas fa-arrow-left"></i> Go Back</a>
        </div>
    </form>
</body>
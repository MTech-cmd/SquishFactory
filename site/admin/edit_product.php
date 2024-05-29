<?php

function cleanInt($val)
{
    return intval(htmlspecialchars(str_replace(array('.', ','), '', $val)));
}

session_start();
if (!isset($_SESSION['AdminID'])) {
    header("Location: login.php");
    die;
}

require "../connector.php";

if ($_GET['type'] === 'mellow') {
    $type = "Mellows";
    $typeid = "ProductID";
} else {
    $type = "Accessories";
    $typeid = "AccessoryID";
}
$sql = "SELECT * FROM {$type} WHERE {$typeid} = :id";
$query = $pdo->prepare($sql);
$query->bindParam(':id', $_GET['id']);
$query->execute();
$product = $query->fetch();

$euro = substr($product['Price'], 0, -2);
$cent = substr($product['Price'], -2);
$price = $euro . "." . $cent;

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (empty($_POST['name']) || empty($_POST['price'])) {
        $_SESSION['skillissue'] = "allfields";
        header("Location: {$_SERVER['REQUEST_URI']}");
        die;
    }

    $price = cleanInt($_POST['price']);

    // Check if a file was uploaded
    if (!empty($_FILES['image']['name'])) {
        // File was uploaded, process it
        if ($_FILES['image']['size'] > 50000000) {
            $_SESSION['skillissue'] = "filesize";
            header("Location: {$_SERVER['REQUEST_URI']}");
            die;
        }

        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filetype = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        if (!in_array($filetype, $allowed)) {
            $_SESSION['skillissue'] = "filetype";
            header("Location: {$_SERVER['REQUEST_URI']}");
            die;
        }

        $filename = "../assets/custom-mellows/" . uniqid() . "." . $filetype;
        move_uploaded_file($_FILES['image']['tmp_name'], $filename);

        // Update the filepath in the database
        $sql = "UPDATE {$type} SET Filepath = :filepath WHERE {$typeid} = :id";
        $query = $pdo->prepare($sql);
        $filename = substr($filename, 2);
        $query->bindParam(':filepath', $filename);
        $query->bindParam(':id', $_GET['id']);
        $query->execute();
    }

    // Update other fields in the database
    $sql = "UPDATE {$type} SET Name = :name, Price = :price WHERE {$typeid} = :id";
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
    <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST" enctype="multipart/form-data">
        <div>
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" name="name" maxlength="60" value="<?= $product['Name'] ?>">
        </div>
        <div>
            <label for="price" class="form-label">Price (Eurocent):</label>
            <input type="number" class="form-control" id="price" name="price" value="<?= $product['Price'] ?>" maxlength="6">
        </div>
        <div>
            <label for="image" class="form-label">Edit Picture:</label>
            <input type="file" class="form-control" id="image" name="image">
            <div class="alert alert-warning mt-2">
                <p class="mb-0">A standard Mellow's picture size is 400x500. It is advised to use this ratio.</p>
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
        <img src="../<?= $product['Filepath'] ?>" alt="Product Image" class="img-fluid mt-2" style="max-width: 100px;">
        <div class="mt-2">
            <button type="submit" class="btn btn-outline-success">Edit</button>
            <a href="remove_product.php?type=<?= $_GET['type'] ?>&id=<?= $product[$typeid] ?>" class="btn btn-outline-danger">
                <i class="fas fa-trash"></i> Delete</a>
            <a href="products.php" class="btn btn-outline-primary"><i class="fas fa-arrow-left"></i> Go Back</a>
        </div>
    </form>
</body>

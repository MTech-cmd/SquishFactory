<?php

require "../connector.php";
if ($_SERVER['REQUEST_METHOD'] === "POST") {

    if (empty($_POST['name'] || $_POST['price'] || $_POST['type'] || $_FILES['image'])) {
        echo "All fields are required.";
    } else {
        if ($_POST['type'] == "Mellow") {
            $targetDir = "../assets/custom-mellows/";
        } else {
            $targetDir = "../assets/accessories/";
        }
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);

        try {
            $stmt = $pdo->prepare("INSERT INTO :category (name, price, type, image) VALUES (:name, :price, :type, :image)");

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':image', $image);

            $stmt->execute();

            echo "Product added successfully.";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        // Close connection
        $pdo = null;
    }
}

include "head.php";
?>

<body class="container mt-3">

    <form action="add_product.php" method="POST">

        <div>
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" name="name" maxlength="60">
        </div>

        <div>
            <label for="price" class="form-label">Price:</label>
            <input type="number" class="form-control" id="price" name="price">
        </div>

        <div>
            <label for="type" class="form-label">Type:</label>
            <select class="form-select" id="type">
                <option>Mellow</option>
                <option>Accessory</option>
            </select>
        </div>

        <div>
            <label for="image" class="form-label">Image:</label>
            <input type="file" class="form-control" id="image" name="image">
            <div class="alert alert-dismissible alert-warning mt-2">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <p class="mb-0">A standard Mellow's picture size is 1340x1560. It is advised to use this ratio.</p>
            </div>


        </div>


        <div class="mt-2">
            <button type="submit" class="btn btn-outline-success">Upload</button>
            <a href="products.php" class="btn btn-outline-primary"><i class="fas fa-arrow-left"></i> Go Back</a>
        </div>

    </form>

</body>
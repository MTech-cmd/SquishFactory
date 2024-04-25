<?php

require "../connector.php";
session_start();
if (!isset($_SESSION['skillissue'])) {
    $_SESSION['skillissue'] = false;
}
if (!isset($_SESSION['AdminID'])) {
    header("Location: login.php");
    die;
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (empty($_POST['name']) || empty($_POST['price']) || empty($_POST['type']) || empty($_POST['image'])) {
        $_SESSION['skillissue'] = true;
    } else {
        $_SESSION['skillissue'] = false;
        
        // TODO: Insert product into database
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
            <?php if ($_SESSION['skillissue']) { ?>
                <div class="alert alert-danger mt-2">
                    <p class="text-white mb-0">Please fill in all fields</p>
                </div>
            <?php } ?>
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
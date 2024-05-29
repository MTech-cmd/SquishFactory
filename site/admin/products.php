<?php

session_start();
if (!isset($_SESSION['AdminID'])) {
    header("Location: login.php");
    die;
}

require "../connector.php";

$sql = "SELECT * FROM Mellows";
$query = $pdo->query($sql);
$mellows = $query->fetchAll();

$sql = "SELECT * FROM Accessories";
$query = $pdo->query($sql);
$accessories = $query->fetchAll();

include "head.php";
?>

<body class="d-flex">

    <!-- Side Navbar -->
    <nav class="bg-black text-white py-2 px-3 d-none d-sm-block" style="width: 250px;">
        <ul class="nav flex-column">
            <li class="navbar-brand mb-3">
                <img src="../assets/logo-admin.png" class="w-100" alt="Admin logo">
            </li>
            <li class="btn-group-vertical">
                <a class="btn btn-info" href="home.php">Home</a>
                <a class="btn btn-outline-info" href="products.php">Products</a>
                <a class="btn btn-info" href="pilot.php">Landing Page</a>
                <a class="btn btn-info" href="coupons.php">Coupons</a>
                <a class="btn btn-info" href="orders.php">Orders</a>
                <a class="btn btn-info" href="accounts.php">Accounts</a>
            </li>
            <li class="mt-3 m-auto">
                <a class="btn btn-outline-danger " href="../logout.php">Log out</a>
            </li>
        </ul>
    </nav>

    <main>
        <!-- Mobile navbar-->
        <a class="btn btn-outline-danger d-sm-none mb-3" data-bs-toggle="offcanvas" href="#offcanvasNav" role="button"
            aria-controls="offcanvasNav">
            <i class="fas fa-bars"></i>
        </a>

        <div class="offcanvas offcanvas-start bg-black text-white" tabindex="-1" id="offcanvasNav">
            <div class="offcanvas-header">
                <img src="../assets/logo-admin.png" class="w-50 m-auto" alt="Admin logo" style="padding-left: 30px;">
                <button type="button" class="btn btn-close m-0" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body m-auto">
                <li class="btn-group-vertical align-items-center">
                    <a class="btn btn-info" href="home.php">Home</a>
                    <a class="btn btn-outline-info" href="products.php">Products</a>
                    <a class="btn btn-info" href="pilot.php">Landing Page</a>
                    <a class="btn btn-info" href="coupons.php">Coupons</a>
                    <a class="btn btn-info" href="orders.php">Orders</a>
                    <a class="btn btn-info" href="accounts.php">Accounts</a>
                </li>
                <div class="mt-3">
                    <a class="btn btn-outline-danger" href="../logout.php">Log out</a>
                </div>
            </div>
        </div>
        <!-- Main Content -->
        <div class="container-fluid">
            <div class="row">
                <?php if (!empty($mellows)) { ?>
                <div class="col-12">
                    <h2 class="text-white">Mellows</h2>
                </div>
                <?php } foreach ($mellows as $mellow) {
                    $euro = substr($mellow['Price'], 0, -2);
                    $cent = substr($mellow['Price'], -2);
                    $price = $euro . "," . $cent;
                    ?>
                <div class="col-md-4 mt-3">
                    <div class="card text-white bg-dark" style="min-width: 150px;">
                        <div class="card-header"><?= $mellow['Name'] ?></div>
                        <div class="text-center">
                            <img src="../<?= $mellow['Filepath'] ?>" class="card-img-top mx-auto d-block"
                                alt="<?= $mellow['Name'] ?>" style="max-width: 100px;">
                        </div>
                        <div class="card-body">
                            <p class="card-text">Price: €<?= $price ?></p>
                            <a class="btn btn-outline-success"
                                href="edit_product.php?type=mellow&id=<?= $mellow['ProductID'] ?>">Edit</a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <div class="row">
                <?php if (!empty($accessories)) { ?>
                <div class="col-12">
                    <h2 class="text-white">Accessories</h2>
                </div>
                <?php } ?>
                <?php foreach ($accessories as $accessory) {
                    $euro = substr($accessory['Price'], 0, -2);
                    $cent = substr($accessory['Price'], -2);
                    $price = $euro . "," . $cent;
                    ?>
                <div class="col-md-4 mt-3">
                    <div class="card text-white bg-dark" style="min-width: 150px;">
                        <div class="card-header"><?= $accessory['Name'] ?></div>
                        <div class="text-center">
                            <img src="../<?= $accessory['Filepath'] ?>" class="card-img-top mx-auto d-block"
                                alt="<?= $accessory['Name'] ?>" style="max-width: 100px;">
                        </div>
                        <div class="card-body">
                            <p class="card-text">Price: €<?= $price ?></p>
                            <a class="btn btn-outline-success"
                                href="edit_product.php?type=accessory&id=<?= $accessory['AccessoryID'] ?>">Edit</a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>

            <a class="btn btn-outline-success mt-3" href="add_product.php">Add Product</a>
        </div>

    </main>
</body>

</html>

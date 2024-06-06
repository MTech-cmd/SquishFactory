<?php

require "connector.php";

session_start();
if (!isset($_SESSION['AdminID'])) {
    header("Location: login.php");
    die;
}

$sql = "SELECT Username, Email, UserID FROM Users";
$query = $pdo->query($sql);
$accounts = $query->fetchAll();

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
                <a class="btn btn-info" href="products.php">Products</a>
                <a class="btn btn-info" href="pilot.php">Landing Page</a>
                <a class="btn btn-info" href="coupons.php">Coupons</a>
                <a class="btn btn-info" href="orders.php">Orders</a>
                <a class="btn btn-outline-info" href="accounts.php">Accounts</a>
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
                <a class="btn btn-info" href="products.php">Products</a>
                <a class="btn btn-info" href="pilot.php">Landing Page</a>
                <a class="btn btn-info" href="coupons.php">Coupons</a>
                <a class="btn btn-info" href="orders.php">Orders</a>
                <a class="btn btn-outline-info" href="accounts.php">Accounts</a>
            </li>
            <div class="mt-3">
                <a class="btn btn-outline-danger" href="../logout.php">Log out</a>
            </div>
        </div>
    </div>
    <!-- Main Content -->
    <div class="container-fluid">
    
        <?php foreach ($accounts as $account) { ?>
            <div class="card bg-dark text-white my-3">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $account['Username']; ?></h5>
                    <p class="card-text"><?php echo $account['Email']; ?></p>
                    <a href="remove_account.php?id=<?= $account['UserID'] ?>" class="btn btn-outline-danger">Remove</a>
                </div>
            </div>
        <?php } ?>
    </div>

</main>
</body>

</html>

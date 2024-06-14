<?php
session_start();
if (!isset($_SESSION['AdminID'])) {
    header("Location: login.php");
    die();
}

require "../connector.php";

// Pagination settings
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch orders with pagination
$sql = "SELECT * FROM Orders LIMIT :limit OFFSET :offset";
$query = $pdo->prepare($sql);
$query->bindParam(':limit', $limit, PDO::PARAM_INT);
$query->bindParam(':offset', $offset, PDO::PARAM_INT);
$query->execute();
$data = $query->fetchAll();

// Fetch total number of orders for pagination
$sqlCount = "SELECT COUNT(*) FROM Orders";
$queryCount = $pdo->query($sqlCount);
$totalOrders = $queryCount->fetchColumn();
$totalPages = ceil($totalOrders / $limit);

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
                <a class="btn btn-outline-info" href="orders.php">Orders</a>
                <a class="btn btn-info" href="accounts.php">Accounts</a>
            </li>
            <li class="mt-3 m-auto">
                <a class="btn btn-outline-danger" href="../logout.php">Log out</a>
            </li>
        </ul>
    </nav>

    <main>
        <!-- Mobile navbar -->
        <a class="btn btn-outline-danger d-sm-none mb-3" data-bs-toggle="offcanvas" href="#offcanvasNav" role="button"
            aria-controls="offcanvasNav">
            <i class="fas fa-bars"></i>
        </a>
    
        <div class="offcanvas offcanvas-start bg-black text-white" tabindex="-1" id="offcanvasNav">
            <div class="offcanvas-header">
                <img src="../assets/logo-admin.png" class="w-50 m-auto" alt="Admin logo" style="padding-left: 30px;">
                <button type="button" class="btn-close m-0" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body m-auto">
                <li class="btn-group-vertical align-items-center">
                    <a class="btn btn-info" href="home.php">Home</a>
                    <a class="btn btn-info" href="products.php">Products</a>
                    <a class="btn btn-info" href="pilot.php">Landing Page</a>
                    <a class="btn btn-info" href="coupons.php">Coupons</a>
                    <a class="btn btn-outline-info" href="orders.php">Orders</a>
                    <a class="btn btn-info" href="accounts.php">Accounts</a>
                </li>
                <div class="mt-3">
                    <a class="btn btn-outline-danger" href="../logout.php">Log out</a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container-fluid">
            <?php if (empty($data)) { ?>
                <p class="text-white">There are no orders :)</p>
            <?php } else {
                foreach ($data as $row) {
                    $sqlName = "SELECT Username FROM Users WHERE UserID = ?";
                    $queryName = $pdo->prepare($sqlName);
                    $queryName->execute([$row['UserID']]);
                    $name = $queryName->fetch()['Username'];
                    ?>
                    <div class="card bg-dark text-white mb-3">
                        <div class="card-header">Order #<?= $row['OrderID'] ?></div>
                        <div class="card-body">
                            <h5 class="card-title">User: <?= $name ?></h5>
                            <p class="card-text">Price: <?= $row['Price'] ?></p>
                        </div>
                    </div>
                <?php } 
            } ?>

            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php if ($page > 1) { ?>
                        <li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a></li>
                    <?php } ?>
                    <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
                    <?php } ?>
                    <?php if ($page < $totalPages) { ?>
                        <li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?>">Next</a></li>
                    <?php } ?>
                </ul>
            </nav>
        </div>
    </main>
</body>
</html>

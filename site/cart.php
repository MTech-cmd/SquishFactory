<?php

session_start();
require "connector.php";

if (!isset($_SESSION['UserID'])) {
    header("Location: require_login.html");
    die();
}

$sql = "SELECT * FROM Mellows";
$query = $pdo->query($sql);
$mellows = $query->fetchAll();

include 'head.php';
?>

<head>
    <title>My Mellow - Cart</title>
</head>

<body class="d-flex flex-column">
    <?php include 'navbar.php'; ?>
    <div class="container mt-2">
        <h1>Cart</h1>
        <div class="card border-primary">
            <div class="card-header">Featured</div>
            <div class="card-body">
                <div class="d-flex">
                    <img src="assets/base-mellows/alpha/black.png" alt="..." class="me-3 mb-2" style="max-width: 100px;">
                    <h2 class="m-auto">1</h2>
                    <h2 class="m-auto">2</h2>
                </div>
                <div class="d-flex">
                    <a href="" class="btn btn-success me-3">+</a>
                    <a href="" class="btn btn-primary">-</a>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>

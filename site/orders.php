<?php
function priceFix($price)
{
    $euro = substr($price, 0, -2);
    $cent = substr($price, -2);
    return "€" . $euro . "," . $cent;
}

session_start();

if (!isset($_SESSION['UserID'])) {
    header("Location: require_login.html");
    die();
}

require 'connector.php';

$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$sql = "SELECT * FROM Orders WHERE UserID = :userID ORDER BY OrderDate DESC LIMIT :limit OFFSET :offset";
$query = $pdo->prepare($sql);
$query->bindParam(':userID', $_SESSION['UserID'], PDO::PARAM_INT);
$query->bindParam(':limit', $limit, PDO::PARAM_INT);
$query->bindParam(':offset', $offset, PDO::PARAM_INT);
$query->execute();
$orders = $query->fetchAll();

$sqlCount = "SELECT COUNT(*) FROM Orders WHERE UserID = ?";
$queryCount = $pdo->prepare($sqlCount);
$queryCount->execute([$_SESSION['UserID']]);
$totalOrders = $queryCount->fetchColumn();
$totalPages = ceil($totalOrders / $limit);

include 'head.php';
?>

<head>
    <title>My Mellow - Orders</title>
</head>

<body class="d-flex flex-column">
    <?php include 'navbar.php'; ?>

    <div class="container mt-2">
        <h1>Orders</h1>

        <?php foreach ($orders as $order) {
            $sqlDetails = "SELECT * FROM Mellows WHERE ProductID = ?";
            $queryDetails = $pdo->prepare($sqlDetails);
            $queryDetails->execute([$order['ProductID']]);
            $mellow = $queryDetails->fetch();
            $name = $mellow['Name'] ?? 'Custom Mellow';
            ?>
            <div class="card border-primary my-1">
                <div class="card-header"><?= $name ?></div>
                <div class="card-body">
                    <div class="d-flex row">
                        <div class="col">
                            <img src=".<?= $mellow['Filepath'] ?>" alt="<?= $name ?>" class="me-3 mb-2" style="max-width: 100px;">
                        </div>
                        <div class="col">
                            <p class="m-0"><b>Amount: </b><?= $order['Amount'] ?>x</p>
                            <p class="m-0"><b>Price: </b><?= priceFix($order['Price']) ?></p>
                            <p class="m-0"><b>Ordered at: </b><?= $order['OrderDate'] ?></p>
                            <p class="m-0"><b>Delivered at: </b><?= $order['ShippingAddress'] ?></p>
                            <p class="m-0"><b>Status: </b><?= $order['Status'] ?></p>
                            <?php if ($order['Status'] == 'Pending') { ?>
                                <a href="receipt.php" class="btn btn-success">Pay</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <nav aria-label="Page navigation">
            <ul class="pagination">
                <?php if ($page > 1) { ?>
                    <li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a></li>
                <?php } ?>
                <?php if ($page < $totalPages) { ?>
                    <li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?>">Next</a></li>
                <?php } ?>
            </ul>
        </nav>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>

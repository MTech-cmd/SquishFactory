<?php

function priceFix($price)
{
    $euro = substr($price, 0, -2);
    $cent = substr($price, -2);
    return "€" . $euro . "," . $cent;
}

session_start();
require 'connector.php';

if (!isset($_SESSION['UserID'])) {
    header("Location: require_login.html");
    die();
}

$sql = "SELECT * FROM Orders WHERE Status = 'Pending' AND UserID = ?";
$query = $pdo->prepare($sql);
$query->execute([$_SESSION['UserID']]);
$orders = $query->fetchAll();

if (!$orders) {
    header("Location: orders.php");
    die();
}

$total = 0;

include 'head.php';
?>

<head>
    <title>My Mellow - Overwiew</title>
</head>

<body class="d-flex flex-column">
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h1>Final overwiew</h1>
        <?php foreach ($orders as $order) {
            $total += $order['Price'];
            $sqlName = "SELECT Name FROM Mellows WHERE ProductID = ?";
            $queryName = $pdo->prepare($sqlName);
            $queryName->execute([$order['ProductID']]);
            ?>
            <div class="alert alert-primary p-0 px-2" role="alert">
                <p class="m-0"><b>Name: </b><?= $queryName->fetch()['Name'] ?? 'Custom Mellow' ?></p>
                <p class="m-0"><b>Amount: </b><?= $order['Amount'] ?>x</p>
                <p class="m-0"><b>Price: </b><?= priceFix($order['Price']) ?></p>
            </div>
        <?php } ?>
        <h3>Total: <?= priceFix($total) ?></h3>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#payModal">Pay</button>

        <div class="modal fade" id="payModal" tabindex="-1" aria-labelledby="payModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="payModalLabel">Payment</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Thank you for using this demo, in the future I plan on implementing Stripe features but for now I will simulate a successfull payment for you!</p>
                    </div>
                    <div class="modal-footer">
                        <a href="handler.php" class="btn btn-success">Pay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
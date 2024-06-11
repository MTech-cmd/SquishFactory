<?php

function priceFix($price)
{
    $euro = substr($price, 0, -2);
    $cent = substr($price, -2);
    return "€" . $euro . "," . $cent;
}

session_start();
require "connector.php";

if (!isset($_SESSION['UserID'])) {
    header("Location: require_login.html");
    die();
}

$total = 0;

$sql = "SELECT * FROM Cart WHERE UserID = ?";
$query = $pdo->prepare($sql);
$query->execute([$_SESSION['UserID']]);
$items = $query->fetchAll();

if (isset($_GET['id'])) {
    $sqlSel = "SELECT Amount FROM Cart WHERE UserID = :user AND ProductID = :mellow";
    $querySel = $pdo->prepare($sqlSel);
    $querySel->bindParam(':user', $_SESSION['UserID']);
    $querySel->bindParam(':mellow', $_GET['id']);
    $querySel->execute();
    $amount = $querySel->fetch()['Amount'];

    if ($_GET['stat'] == 'add') {
        if ($amount == 0) {
            $sqlMod = "INSERT INTO Cart (UserID, ProductID, Amount) VALUES (:user, :mellow, 1)";
        } else {
            $sqlMod = "UPDATE Cart SET Amount = Amount + 1 WHERE UserID = :user AND ProductID = :mellow";
        }
    } elseif ($_GET['stat'] == 'del') {
        if ($amount > 1) {
            $sqlMod = "UPDATE Cart SET Amount = Amount - 1 WHERE UserID = :user AND ProductID = :mellow";
        } else {
            $sqlMod = "DELETE FROM Cart WHERE UserID = :user AND ProductID = :mellow";
        }
    }

    $queryMod = $pdo->prepare($sqlMod);
    $queryMod->bindParam(':user', $_SESSION['UserID']);
    $queryMod->bindParam(':mellow', $_GET['id']);
    $queryMod->execute();

    header("Location: cart.php");
    die();
}

include 'head.php';
?>

<head>
    <title>My Mellow - Cart</title>
</head>

<body class="d-flex flex-column">
    <?php include 'navbar.php'; ?>
    <div class="container mt-2">
        <h1>Cart</h1>

        <?php if (empty($items)) { ?>
        <div class="alert alert-warning" role="alert">
            Your cart is empty.
        </div>
        <?php } else {
            foreach ($items as $item) { 
                $sqlMellows = "SELECT * FROM Mellows WHERE ProductID = ?";
                $queryMellows = $pdo->prepare($sqlMellows);
                $queryMellows->execute([$item['ProductID']]);
                $mellow = $queryMellows->fetch();
                $name = $mellow['Name'] ?? 'Your own imagination!';
                $price = $mellow['Price'] * $item['Amount'];
                $total += $price;
                $price = priceFix($price);
                ?>
        <div class="card border-primary my-1">
            <div class="card-header"><?= $name ?></div>
            <div class="card-body">
                <div class="d-flex">
                    <img src=".<?= $mellow['Filepath'] ?>" alt="<?= $name ?>" class="me-3 mb-2"
                        style="max-width: 100px;">
                    <h3 class="m-auto"><?= $price ?></h3>
                </div>
                <div class="d-flex">
                    <a href="cart.php?id=<?= $item['ProductID'] ?>&stat=add" class="btn btn-success me-3">+</a>
                    <a href="cart.php?id=<?= $item['ProductID'] ?>&stat=del" class="btn btn-primary">-</a>
                    <h3 class="m-auto">Quantity: <?= $item['Amount'] ?></h3>
                </div>
            </div>
        </div>
            <?php }
        } if ($total != 0) { ?>
        <a href="checkout.php" class="btn btn-success">Checkout</a>
        <p>Total: <?= priceFix($total) ?></p>
        <?php } ?>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>

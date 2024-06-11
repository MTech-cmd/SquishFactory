<?php

session_start();
require 'connector.php';

$sql = "SELECT * FROM Users WHERE UserID = ?";
$query = $pdo->prepare($sql);
$query->execute([$_SESSION['UserID']]);
$user = $query->fetch();

if (!isset($_SESSION['skillissue'])) {
    $_SESSION['skillissue'] = null;
}

include 'head.php';
?>

<head>
    <title>My Mellow - Checkout</title>
</head>

<body class="d-flex flex-column">
    <?php include 'navbar.php'; ?>

    <div class="container mt-2">
        <h1>Checkout</h1>

        <form action="confirm.php" method="POST">

            <div class="form-floating">
                <input type="text" class="form-control m-1" id="firstName" name="firstName" placeholder="First Name"
                    value="<?= $user['FirstName'] ?>" maxlength="60" required>
                <label for="firstName">First Name</label>
            </div>

            <div class="form-floating">
                <input type="text" class="form-control m-1" id="lastName" name="lastName" placeholder="Last Name"
                    value="<?= $user['LastName'] ?>" maxlength="60" required>
                <label for="lastName">Last Name</label>
            </div>

            <div class="form-floating">
                <input type="text" class="form-control m-1" id="billingAddress" name="billingAddress"
                    placeholder="Billing Address" value="<?= $user['BillingAddress'] ?? '' ?>" maxlength="255" required>
                <label for="billingAddress">Billing Address</label>
            </div>

            <div class="form-floating">
                <input type="text" class="form-control m-1" id="shippingAddress" name="shippingAddress" placeholder="Shipping Address" value="<?= $user['BillingAddress'] ?? '' ?>" maxlength="255" required>
                <label for="shippingAddress">Shipping Address</label>
            </div>

            <div class="form-floating">
                <input type="email" class="form-control m-1" id="email" name="email" placeholder="E-mail" value="<?= $user['Email'] ?>" maxlength="255" required>
                <label for="email">E-mail</label>
            </div>

            <div class="form-floating">
                <input type="text" class="form-control m-1" id="phone" name="phone" placeholder="Phone Number" value="<?= $user['Phone'] ?? '' ?>" maxlength="30" required>
                <label for="phone">Phone Number</label>
            </div>

            <div class="form-floating">
                <input type="text" class="form-control m-1" id="coupon" name="coupon" placeholder="Coupon Code" maxlength="255">
                <label for="coupon">Coupon Code</label>
            </div>

            <button type="submit" class="btn btn-success m-1">Confirm</button>

        </form>

    </div>
    <?php include 'footer.php'; ?>
</body>

</html>

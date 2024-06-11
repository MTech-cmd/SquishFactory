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

function skillissue($arr)
{
    if (strlen($arr['firstName']) > 60 || empty($arr['firstName'])) {
        return 'firstName';
    }

    if (strlen($arr['lastName']) > 60 || empty($arr['lastName'])) {
        return 'lastName';
    }

    if (strlen($arr['billingAddress']) > 255 || empty($arr['billingAddress'])) {
        return 'billingAddress';
    }

    if (strlen($arr['shippingAddress']) > 255 || empty($arr['shippingAddress'])) {
        return 'shippingAddress';
    }

    if (strlen($arr['phone']) > 30 || empty($arr['phone'])) {
        return 'phone';
    }

    if (strlen($arr['email']) > 60 || empty($arr['email']) || !(filter_var($arr['email'], FILTER_VALIDATE_EMAIL))) {
        return 'email';
    }

    if (strlen($arr['coupon']) > 255) {
        return 'coupon';
    }

    return null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $param['firstName'] = htmlspecialchars($_POST['firstName']);
    $param['lastName'] = htmlspecialchars($_POST['lastName']);
    $param['billingAddress'] = htmlspecialchars($_POST['billingAddress']);
    $param['shippingAddress'] = htmlspecialchars($_POST['shippingAddress']);
    $param['phone'] = htmlspecialchars($_POST['phone']);
    $param['email'] = htmlspecialchars($_POST['email']);
    $param['coupon'] = htmlspecialchars($_POST['coupon']);
    $_SESSION['skillissue'] = skillissue($param);

    if (!$_SESSION['skillissue']) {
        $sqlIns = "INSERT INTO Orders (UserID, FirstName, LastName, BillingAddress, ShippingAddress, Phone, Email, CouponCode) 
                VALUES (:userID, :firstName, :lastName, :billingAddress, :shippingAddress, :phone, :email, :coupon)";
        $queryIns = $pdo->prepare($sqlIns);
        $query->bindParam(':userID', $_SESSION['UserID']);
        $query->bindParam(':firstName', $param['firstName']);
        $query->bindParam(':lastName', $param['lastName']);
        $query->bindParam(':billingAddress', $param['billingAddress']);
        $query->bindParam(':shippingAddress', $param['shippingAddress']);
        $query->bindParam(':phone', $param['phone']);
        $query->bindParam(':email', $param['email']);
        $query->bindParam(':coupon', $param['coupon']);
        $query->execute();
        header('Location: orders.php');
    }
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

        <form action="checkout.php" method="POST">

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

        </form>

    </div>
    <?php include 'footer.php'; ?>
</body>

</html>

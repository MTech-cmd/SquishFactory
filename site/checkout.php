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

if (!isset($_SESSION['UserID'])) {
    header("Location: require_login.html");
    die();
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

    return null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['coupon'])) {
        $sqlCoupon = "SELECT * FROM Coupons WHERE Code = ?";
        $queryCoupon = $pdo->prepare($sqlCoupon);
        $queryCoupon->execute([$_POST['coupon']]);
        $data = $queryCoupon->fetch();
        $coupon = $data['CouponID'];
        if (!$data['Percentage']) {
            $discount = $data['Amount'];
        }
    } else {
        $coupon = null;
    }

    $param['firstName'] = htmlspecialchars($_POST['firstName']);
    $param['lastName'] = htmlspecialchars($_POST['lastName']);
    $param['billingAddress'] = htmlspecialchars($_POST['billingAddress']);
    $param['shippingAddress'] = htmlspecialchars($_POST['shippingAddress']);
    $param['phone'] = htmlspecialchars($_POST['phone']);
    $param['email'] = htmlspecialchars($_POST['email']);
    $_SESSION['skillissue'] = skillissue($param);

    $queryProds = $pdo->prepare("SELECT * FROM Cart WHERE UserID = ?");
    $queryProds->execute([$_SESSION['UserID']]);
    $prods = $queryProds->fetchAll();

    foreach ($prods as $prod) {
        if (!$_SESSION['skillissue']) {
            $_SESSION['skillissue'] = null;

            $queryMel = $pdo->prepare("SELECT * FROM Mellows WHERE ProductID = ?");
            $queryMel->execute([$prod['ProductID']]);
            $mel = $queryMel->fetch();
            $price = $mel['Price'] * $prod['Amount'];
            if ($data['Percentage']) {
                $price = $price - ($price * $data['Amount'] / 100);
            } elseif ($discount >= $price) {
                $discount -= $price;
                $price = 0;
            } else {
                $price = $price - $discount;
            }
    
            $date = date('Y-m-d H:i:s');
    
            $sql = "INSERT INTO Orders (UserID, FirstName, LastName, BillingAddress, ShippingAddress, Phone, Email, CouponID, OrderDate, Price, ProductID, Amount) 
                    VALUES (:userID, :firstName, :lastName, :billingAddress, :shippingAddress, :phone, :email, :coupon, :date, :price, :productID, :amount)";
            $query = $pdo->prepare($sql);
            $query->bindParam(':userID', $_SESSION['UserID']);
            $query->bindParam(':firstName', $param['firstName']);
            $query->bindParam(':lastName', $param['lastName']);
            $query->bindParam(':billingAddress', $param['billingAddress']);
            $query->bindParam(':shippingAddress', $param['shippingAddress']);
            $query->bindParam(':phone', $param['phone']);
            $query->bindParam(':email', $param['email']);
            $query->bindParam(':date', $date);
            $query->bindParam(':coupon', $coupon);
            $query->bindParam(':price', $price);
            $query->bindParam(':productID', $prod['ProductID']);
            $query->bindParam(':amount', $prod['Amount']);
            $query->execute();
        }
    }
    if (!isset($_SESSION['skillissue'])) {
        $sqlDel = "DELETE FROM Cart WHERE UserID = ?";
        $queryDel = $pdo->prepare($sqlDel);
        $queryDel->execute([$_SESSION['UserID']]);
        header('Location: receipt.php');
        die();
    }
    header('location: checkout.php');
    die();
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

            <button type="submit" class="btn btn-success m-1">Confirm</button>

        </form>

    </div>
    <?php include 'footer.php'; ?>
</body>

</html>

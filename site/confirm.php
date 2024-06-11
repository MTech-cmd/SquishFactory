<?php

session_start();
require 'connector.php';

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
            $id = $pdo->lastInsertId();
            header('Location: orders.php');
            die();
        }
    }
}

header('location: checkout.php');
die();

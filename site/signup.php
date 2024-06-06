<?php

require "connector.php";
session_start();

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

    if (strlen($arr['address']) > 255) {
        return 'address';
    }

    if (strlen($arr['phone']) > 30) {
        return 'phone';
    }

    if (strlen($arr['email']) > 60 || empty($arr['email']) || !(filter_var($arr['email'], FILTER_VALIDATE_EMAIL))) {
        return 'email';
    }

    if (strlen($arr['username']) > 60 || empty($arr['username'])) {
        return 'username';
    }
    return null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $param['firstName'] = htmlspecialchars($_POST['firstName']);
    $param['lastName'] = htmlspecialchars($_POST['lastName']);
    $param['address'] = empty($_POST['address']) ? 'NA' : htmlspecialchars($_POST['address']);
    $param['phone'] = empty($_POST['phone']) ? 'NA' : htmlspecialchars($_POST['phone']);
    $param['email'] = htmlspecialchars($_POST['email']);
    $param['username'] = htmlspecialchars($_POST['username']);
    if (empty($_POST['password'])) {
        $_SESSION['skillissue'] = "password";
    }
        $_SESSION['skillissue'] = skillissue($param);

    if (!$_SESSION['skillissue']) {
        $sql = "INSERT INTO Users (FirstName, LastName, BillingAddress, Phone, Email, Username, Password) 
                VALUES (:firstName, :lastName, :address, :phone, :email, :username, :password)";
        $query = $pdo->prepare($sql);
        $query->bindParam(':firstName', $param['firstName']);
        $query->bindParam(':lastName', $param['lastName']);
        $query->bindParam(':address', $param['address']);
        $query->bindParam(':phone', $param['phone']);
        $query->bindParam(':email', $param['email']);
        $query->bindParam(':username', $param['username']);
        $query->bindParam(':password', password_hash($_POST['password'], PASSWORD_DEFAULT));
        $query->execute();

        $_SESSION['skillissue'] = null;

        header("Location: login.php");
        ob_end_flush();
        die();
    }
    header("Location: signup.php");
    die();
}

include "head.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Mellow - Sign Up</title>
</head>
<body>
    <?php include "navbar.php"; ?>
    <div class="container mt-2">
        <h1>Sign up today!</h1>
        <form action="signup.php" method="POST">

            <div class="form-floating">
                <input type="text" class="form-control m-1 <?= $_SESSION['skillissue'] === 'firstName' ? 'is-invalid' : '' ?>" id="firstName" name="firstName" placeholder="First Name"
                    maxlength="60">
                <label for="firstName">First Name</label>
            </div>

            <div class="form-floating">
                <input type="text" class="form-control m-1 <?= $_SESSION['skillissue'] === 'lastName' ? 'is-invalid' : '' ?>" id="lastName" name="lastName" placeholder="Last Name"
                    maxlength="60">
                <label for="lastName">Last Name</label>
            </div>

            <div class="form-floating">
                <input type="text" class="form-control m-1 <?= $_SESSION['skillissue'] === 'address' ? 'is-invalid' : '' ?>" id="address" name="address" placeholder="Address"
                    maxlength="255">
                <label for="address">Address</label>
            </div>

            <div class="form-floating">
                <input type="text" class="form-control m-1 <?= $_SESSION['skillissue'] === 'phone' ? 'is-invalid' : '' ?>" id="phone" name="phone" placeholder="Phone Number"
                    maxlength="30">
                <label for="phone">Phone Number</label>
            </div>

            <div class="form-floating">
                <input type="email" class="form-control m-1 <?= $_SESSION['skillissue'] === 'email' ? 'is-invalid' : '' ?>" id="email" name="email" placeholder="Email Address"
                    maxlength="60">
                <label for="email">Email Address</label>
            </div>

            <div class="form-floating">
                <input type="text" class="form-control m-1 <?= $_SESSION['skillissue'] === 'username' ? 'is-invalid' : '' ?>" id="username" name="username" placeholder="Username"
                    maxlength="60">
                <label for="username">Username</label>
            </div>

            <div class="form-floating">
                <input type="password" class="form-control m-1 <?= $_SESSION['skillissue'] === 'password' ? 'is-invalid' : '' ?>" id="password" name="password" placeholder="Password">
                <label for="password">Password</label>
            </div>

            <input type="submit" class="btn btn-success" value="Register">
            <a href="index.php" class="btn btn-info"><i class="fas fa-arrow-left"></i> Go Back</a>

        </form>
    </div>
</body>
</html>

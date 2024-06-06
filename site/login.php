<?php

require "connector.php";
session_start();

if (!isset($_SESSION['skillissue'])) {
    $_SESSION['skillissue'] = null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "SELECT * FROM Users WHERE Username = :username";
    $query = $pdo->prepare($sql);
    $query->bindParam(':username', $_POST['username']);
    $query->execute();
    $user = $query->fetch();

    if (password_verify($_POST['password'], $user['Password'])) {
        $_SESSION['UserID'] = $user['UserID'];
        $_SESSION['skillissue'] = null;
        header("Location: index.php");
        die();
    } else {
        $_SESSION['skillissue'] = 'login_user';
    }

    header("Location: login.php");
    die();
}

include "head.php"; 
?>

<head>
    <title>My Mellow - Login</title>
</head>

<body>
    <?php include "navbar.php" ?>

    <div class="container mt-2">
        <h1>Login</h1>
        <form action="login.php" method="POST">

            <div class="form-floating">
                <input type="text" class="form-control m-1 <?= $_SESSION['skillissue'] === 'login_user' ? 'is-invalid' : '' ?>" id="username" name="username" placeholder="Username"
                    maxlength="60">
                <label for="username">Username</label>
                <?php if ($_SESSION['skillissue'] === 'login_user') { ?>
                    <div class="invalid-feedback">Wrong username or password</div>
                <?php } ?>
            </div>

            <div class="form-floating">
                <input type="password" class="form-control m-1 <?= $_SESSION['skillissue'] === 'login_user' ? 'is-invalid' : '' ?>" id="password" name="password" placeholder="Password">
                <label for="password">Password</label>
            </div>

            <input type="submit" class="btn btn-success" value="Login">
            <a href="index.php" class="btn btn-info"><i class="fas fa-arrow-left"></i> Go Back</a>

        </form>
    </div>
</body>

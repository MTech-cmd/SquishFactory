<?php

require "../connector.php";
session_start();
if (!isset($_SESSION['skillissue'])) {
    $_SESSION['skillissue'] = false;
}
if (isset($_SESSION['AdminID'])) {
    header("Location: home.php");
    die;
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $sql = "SELECT AdminID, Password FROM Admins WHERE Username = :username;";
    $query = $pdo->prepare($sql);
    $query->bindParam(':username', $_POST['username']);
    $query->execute();
    $data = $query->fetch(PDO::FETCH_ASSOC);
    if (password_verify($_POST['password'], $data['Password'])) {
        $_SESSION['skillissue'] = false;
        $_SESSION['AdminID'] = $data['AdminID'];
        header("Location: home.php");
        die;
    } else {
        $_SESSION['skillissue'] = true;
    }
}

include "head.php";
?>

<body class="d-flex justify-content-center">
    <div class="text-center">

        <header>
            <img src="../assets/logo-admin.png" class="w-25 mt-5" alt="Admin logo">
        </header>

        <form class="mt-5 w-50 m-auto" action="login.php" method="POST">

            <div>
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username" maxlength="60">
            </div>

            <div>
                <label for="password" class="form-label mt-2">Password:</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <?php if ($_SESSION['skillissue']) { ?>
                <div class="alert alert-danger mt-2 p-1" role="alert">
                    <p class="text-white">Incorrect username or password</p>
                </div>
            <?php } ?>
            <button type="submit" class="btn btn-info mt-2">Log in</button>
        </form>

    </div>
</body>

<?php

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    header("Location: login.php");
    die;
}
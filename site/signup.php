<?php

require "connector.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = htmlspecialchars($_POST['firstName']);
    $lastname = htmlspecialchars($_POST['lastName']);
    $address = htmlspecialchars($_POST['address']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO Users (FirstName, LastName, BillingAddress, Phone, Email, Username, Password) VALUES (:firstname, :lastname, :address, :phone, :email, :username, :password)";
    $query = $pdo->prepare($sql);
    $query->bindParam(':firstname', $firstname);
    $query->bindParam(':lastname', $lastname);
    $query->bindParam(':address', $address);
    $query->bindParam(':phone', $phone);
    $query->bindParam(':email', $email);
    $query->bindParam(':username', $username);
    $query->bindParam(':password', $password);
    $query->execute();
}

include "head.php";
?>

<body>
    <div class="container mt-2">
        <h1>Sign up today!</h1>
        <form action="signup.php" method="POST">

            <div class="form-floating">
                <input type="text" class="form-control m-1" id="firstName" name="firstName" placeholder="First Name"
                    maxlength="60">
                <label for="firstName">First Name</label>
            </div>

            <div class="form-floating">
                <input type="text" class="form-control m-1" id="lastName" name="lastName" placeholder="Last Name"
                    maxlength="60">
                <label for="lastName">Last Name</label>
            </div>

            <div class="form-floating">
                <input type="text" class="form-control m-1" id="address" name="address" placeholder="Address"
                    maxlength="255">
                <label for="address">Address</label>
            </div>

            <div class="form-floating">
                <input type="text" class="form-control m-1" id="phone" name="phone" placeholder="Phone Number"
                    maxlength="30">
                <label for="phone">Phone Number</label>
            </div>

            <div class="form-floating">
                <input type="email" class="form-control m-1" id="email" name="email" placeholder="Email Address"
                    maxlength="60">
                <label for="email">Email Address</label>
            </div>

            <div class="form-floating">
                <input type="text" class="form-control m-1" id="username" name="username" placeholder="Username"
                    maxlength="60">
                <label for="username">Username</label>
            </div>

            <div class="form-floating">
                <input type="password" class="form-control m-1" id="password" name="password" placeholder="Password">
                <label for="password">Password</label>
            </div>

            <input type="submit" class="btn btn-success" value="Register">
            <a href="index.php" class="btn btn-info"><i class="fas fa-arrow-left"></i> Go Back</a>

        </form>
    </div>
</body>

</html>

<?php

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    header("Location: signup.php");
    die;
}

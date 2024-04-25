<?php

try {
    require "../connector.php";
} catch (Exception $e) {
    echo "Connector File missing, terminating program\n{$e}\n";
    die;
}

$username = readline("Enter username: ");
if (strlen($username) >= 60) {
    echo "Username must be less than 60 charachters";
    die;
}
$username = htmlspecialchars($username);
$password = readline("\nEnter password: ");
$password = password_hash($password, PASSWORD_DEFAULT);

try {
    $query = $pdo->prepare("INSERT INTO `Admins`(Username, Password) VALUES (:username, :password);");
    $params = array(
        ':username' => $username,
        ':password' => $password
    );
    bindparams($query, $params);
    $query->execute();
    echo "User added successfully!\n";
} catch (Exception $e) {
    echo "An error occurred:\n{$e}\n";
}
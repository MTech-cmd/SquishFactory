<?php

require "connector.php";

$sql = "DELETE FROM Users WHERE UserID = ?";
$query = $pdo->prepare($sql);
$query->execute([$_GET['id']]);
header("Location: accounts.php");
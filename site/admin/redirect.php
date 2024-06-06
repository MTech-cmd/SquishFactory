<?php

session_start();
if (!isset($_SESSION['AdminID'])) {
    header("Location: ../cart.php");
    die;
} else {
    header("Location: pilot.php");
    die;
}
?>
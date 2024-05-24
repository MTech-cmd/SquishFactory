<?php

function cleanInt($val)
{
    return intval(htmlspecialchars(str_replace(array('.', ','), '', $val)));
}

function randomCode($n)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < $n; $i++) {
        $randstring .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randstring;
}

session_start();
if (!isset($_SESSION['AdminID'])) {
    header("Location: login.php");
    die;
}

require "../connector.php";

$sql = "SELECT * FROM Coupons WHERE CouponID = :id";
$query = $pdo->prepare($sql);
$query->bindParam(':id', $_GET['id']);
$query->execute();
$coupon = $query->fetch();

$selectors = array("percent" => "",
                   "one-time" => "",
                   "closed" => "");

if ($coupon['Percentage'] == 1) {
    $selectors['percent'] = "selected";
}

switch ($coupon['Status']) {
    case "One-Time":
        $selectors['one-time'] = "selected";
        break;
    case "Closed":
        $selectors['closed'] = "selected";
        break;
    default:
        break;
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (empty($_POST['amount'])) {
        $_SESSION['skillissue'] = "allfields";
        header("Location: {$_SERVER['REQUEST_URI']}");
        die;
    }

    $_SESSION['skillissue'] = null;

    // Code sanitization
    $amount = cleanInt($_POST['amount']);

    if ($_POST['unit'] === "Eurocent") {
        $unit = 0;
    } else {
        $unit = 1;
    }

    // Update other fields in the database
    $sql = "UPDATE Coupons SET Amount = :amount, Percentage = :percentage, Status = :status, AdminID = :adminid WHERE CouponID = :id";
    $query = $pdo->prepare($sql);
    $query->bindParam(':amount', $amount);
    $query->bindParam(':percentage', $unit);
    $query->bindParam(':status', $_POST['status']);
    $query->bindParam(':adminid', $_SESSION['AdminID']);
    $query->bindParam(':id', $_GET['id']);
    $query->execute();

    header("Location: products.php");
    die;
}

include "head.php";
?>

<body class="container mt-3">
    <form action="edit_coupon.php" method="POST">
        <div>
            <label for="unit" class="form-label">Unit:</label>
            <select class="form-select" id="unit" name="unit">
                <option>Eurocent</option>
                <option <?= $selectors['percent'] ?> >Percent</option>
            </select>

            <label for="amount" class="form-label">Amount:</label>
            <input type="number" class="form-control" id="amount" name="amount" value="<?= $coupon['Amount'] ?>">
            
            <label for="status" class="form-label">Status:</label>
            <select class="form-select" id="status" name="status" value="<?= $coupon['Status'] ?>">
                <option>Open</option>
                <option <?= $selectors['closed'] ?> >Closed</option>
                <option <?= $selectors['one-time'] ?> >One-Time</option>
            </select>
            <?php if ($_SESSION['skillissue'] === "allfields") { ?>
                <div class="alert alert-danger mt-2">
                    <p class="text-white mb-0">Please fill in the amount</p>
                </div>
            <?php } ?>
        </div>
        <div class="mt-2">
            <button type="submit" class="btn btn-outline-success">Upload</button>
            <a href="coupons.php" class="btn btn-outline-primary"><i class="fas fa-arrow-left"></i> Go Back</a>
        </div>

    </form>

</body>
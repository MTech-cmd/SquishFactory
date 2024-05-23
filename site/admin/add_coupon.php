<?php

require "../connector.php";

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
if (!isset($_SESSION['skillissue'])) {
    $_SESSION['skillissue'] = null;
}

if (!isset($_SESSION['AdminID'])) {
    header("Location: login.php");
    die;
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (empty($_POST['amount'])) {
        $_SESSION['skillissue'] = "allfields";
    } else {
        $_SESSION['skillissue'] = null;

        if (empty($_POST['code'])) {
            $code = randomCode(8);
        } else {
            $code = $_POST['code'];
        }

        $code = htmlspecialchars($code);
        $amount = cleanInt($_POST['amount']);

        if ($_POST['unit'] === "Eurocent") {
            $unit = 0;
        } else {
            $unit = 1;
        }

        $sql = "INSERT INTO Coupons (Amount, Percentage, Code, Status, AdminID) VALUES (:amount, :unit, :code, :stat, :id)";
        $query = $pdo->prepare($sql);
        $query->bindParam(':amount', $amount);
        $query->bindParam(':unit', $unit);
        $query->bindParam(':code', $code);
        $query->bindParam(':stat', $_POST['status']);
        $query->bindParam(':id', $_SESSION['AdminID']);
        $query->execute();

        header("Location: coupons.php");
        die;
    }
}

include "head.php";
?>

<body class="container mt-3">
    <form action="add_coupon.php" method="POST">
        <div>
            <label for="unit" class="form-label">Unit:</label>
            <select class="form-select" id="unit" name="unit">
                <option>Eurocent</option>
                <option>Percent</option>
            </select>

            <label for="amount" class="form-label">Amount:</label>
            <input type="number" class="form-control" id="amount" name="amount">

            <label for="code" class="form-label">Code: (leave empty to autogenerate)</label>
            <input type="text" class="form-control" id="code" name="code">
            
            <label for="status" class="form-label">Status:</label>
            <select class="form-select" id="status" name="status">
                <option>Open</option>
                <option>Closed</option>
                <option>One-Time</option>
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

<?php

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    header("Location: add_coupon.php");
    die;
}

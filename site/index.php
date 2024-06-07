<?php

require "connector.php";
session_start();

$cardStyles = ['primary', 'dark', 'info', 'light', 'danger', 'warning', 'secondary'];

function priceFix($price)
{
    $euro = substr($price, 0, -2);
    $cent = substr($price, -2);
    return "€" . $euro . "," . $cent;
}

$sqlExample = "SELECT Filepath FROM Examples";
$queryExample = $pdo->query($sqlExample);
$examples = $queryExample->fetchAll(PDO::FETCH_NUM);

$sqlCustom = "SELECT * FROM Mellows WHERE Custom = 1";
$queryCustom = $pdo->query($sqlCustom);
$customMellows = $queryCustom->fetchAll();

include 'head.php';
?>

<head>
    <title>My Mellow</title>
</head>

<body class="d-flex flex-column">
    <div class="d-block">
        <header>
            <?php include 'navbar.php'; ?>

            <!-- Start Main Slideshow-->
            <div id="carouselExampleSlidesOnly" class="carousel slide bg-nav" data-bs-ride="carousel"
                data-bs-pause="false">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="./assets/landing/default.png" class="d-block mx-auto w-25"
                            alt="Red Mellow with headphones">
                    </div>
                    <?php if (!empty($examples)) {
                        foreach ($examples as $exampleMellow) { ?>
                    <div class="carousel-item">
                        <img src="./<?= $exampleMellow[0] ?>" class="d-block mx-auto w-25"
                            alt="Example Mellow: <?= $exampleMellow ?>">
                    </div>
                        <?php } 
                    } ?>
                </div>
                <div class="carousel-caption d-none d-md-block">
                    <a href="imager.php" class="btn btn-info mx-4">Customize Now!</a>
                </div>
            </div>
            <!-- End Main Slideshow-->
        </header>

        <main class="px-2 px-md-5">
            <h1 class="text-center mt-2" id="scrollspy">Custom Mellows</h1>
            <div class="row">
                <?php for ($i = 0; $i < sizeof($customMellows); $i++) { ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="m-0 mb-2 card border-<?= $cardStyles[$i] ?>">
                        <div class="card-header"><?= $customMellows[$i]['Name'] ?></div>
                        <div class="card-body">
                            <div class="card-img mb-1">
                                <img src=".<?= $customMellows[$i]['Filepath'] ?>"
                                    style="max-width: 15rem;">
                            </div>
                            <div class="card-text">
                                <a href="add.php?id=<?= $customMellows[$i]['ProductID'] ?>" class="btn btn-success">Buy Now!</a> <?= priceFix($customMellows[$i]['Price']) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </main>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>

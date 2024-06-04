<?php

require "connector.php";

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

        <main class="px-5">
            <h1 class="text-center mt-2">Custom Mellows</h1>
            <div class="d-flex">
                <?php for ($i = 0; $i < sizeof($customMellows); $i++) { ?>
                <div class="card border-<?= $cardStyles[$i] ?> m-3">
                    <div class="card-header"><?= $customMellows[$i]['Name'] ?></div>
                    <div class="card-body">
                        <div class="card-img mb-1"><img src=".<?= $customMellows[$i]['Filepath'] ?>" style="max-width: 15rem;"></div>
                        <div class="card-text"><a class="btn btn-success">Buy Now!</a> <?= priceFix($customMellows[$i]['Price']) ?></div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </main>

    </div>
    <?php include 'footer.php'; ?>
</body>

</html>

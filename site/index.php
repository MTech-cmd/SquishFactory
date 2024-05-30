<?php

require "connector.php";

$sqlExample = "SELECT Filepath FROM Examples";
$queryExample = $pdo->query($sqlExample);
$examples = $queryExample->fetchAll(PDO::FETCH_NUM);

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
            <div id="carouselExampleSlidesOnly" class="carousel slide bg-nav" data-bs-ride="carousel" data-bs-pause="false">
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
                    <a href="#" class="btn btn-info mx-4">Customize Now!</a>
                </div>
            </div>
            <!-- End Main Slideshow-->
        </header>

        <main class="px-5">
            <h1 class="text-center mt-2">Custom Mellows</h1>
            <?php foreach (scandir('assets/custom-mellows') as $customMellow) { 
                if ($customMellow != '.' && $customMellow != '..') { ?>
            <div class="card border-primary mb-3" style="max-width: 15rem;">
                <div class="card-header">Custom Mellow</div>
                <!-- TODO: Pull title from DB -->
                <div class="card-body">
                    <img src="assets/custom-mellows/<?= $customMellow ?>" class="card-img-top"
                        alt="Custom Mellow: <?= $customMellow ?>">
                </div>
                <div class="card-footer">
                    <p class="card-text">Price: €<?= rand(10, 50) ?></p>
                    <a class="btn btn-success d-flex justify-content-center" href="#">Buy Now!</a>
                </div>
            </div>
                <?php }
            } ?>
        </main>

    </div>
    <?php include 'footer.php'; ?>
</body>

</html>

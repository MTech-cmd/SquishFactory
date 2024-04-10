<?php

require_once 'head.php';
?>

<head>
    <title>My Mellow</title>
</head>

<body>

    <header>

        <?php require_once 'navbar.php'; ?>

        <!-- Start Main Slideshow-->
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel" data-bs-pause="false">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="assets/examples/default.png" class="d-block mx-auto w-25" alt="Red Mellow with headphones">
                </div>
                <!-- TODO: Port to PDO -->
                <!-- TODO: Set fixed img size -->
                <?php foreach (scandir('assets/examples') as $exampleMellow) {
                    if ($exampleMellow != '.' && $exampleMellow != '..' && $exampleMellow != 'default.png') { ?>
                        <div class="carousel-item">
                            <img src="assets/examples/<?= $exampleMellow ?>" class="d-block mx-auto w-25" alt="Example Mellow: <?= $exampleMellow ?>">
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
                    <img src="assets/custom-mellows/<?= $customMellow ?>" class="card-img-top" alt="Custom Mellow: <?= $customMellow ?>">
                </div>
                <div class="card-footer">
                    <p class="card-text">Price: €<?= rand(10, 50) ?></p>
                    <a class="btn btn-success d-flex justify-content-center" href="#">Buy Now!</a>
                </div>
            </div>
            <?php }
        } ?>
    </main>

    <footer class="bg-nav text-center p-1 mt-auto">
        <p>&copy; 2021 My Mellow</p>
    </footer>
</body>

</html>

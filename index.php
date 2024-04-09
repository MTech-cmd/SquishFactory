<?php

$UserLoggedIn = false;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Mehdi El Khallouki">
    <meta name="description" content="A website where you can customize and order your own squishmellow">
    <title>My Mellow</title>
    <link rel="icon" href="assets/favicon.svg">
    <link rel="stylesheet" href="stylesheets/style.css">
    <script type="module" src="scripts/script.js"></script>
</head>

<body>

    <header>

        <!-- Start Navbar -->
        <nav class="navbar navbar-expand-md bg-nav" data-bs-theme="dark">
            <div class="container-fluid">
                <!-- Left side -->
                <a class="navbar-brand m-0 p-0 mx-1 " href="#">
                    <img src="assets/logo.svg" alt="Logo" width="115">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02"
                    aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-between" id="navbarColor02">
                    <!-- Collapsible content -->
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="#">Offering</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Merch (Coming Soon)</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Locations</a></li>
                    </ul>

                    <ul class="navbar-nav justify-content-around ">
                        
                        <!-- Right side -->
                        
                        <?php if ($UserLoggedIn) { ?>
                            <li class="nav-item dropdown">
                                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                    <i class="far fa-id-badge fa-lg icon-link"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#">Cart</a></li>
                                    <li><a class="dropdown-item" href="#">Orders</a></li>
                                    <li><a class="dropdown-item" href="#">Coupons</a></li>
                                    <li><a class="dropdown-item" href="#">Settings</a></li>
                                    <li><a class="btn btn-primary d-flex m-1 mb-0" href="#">Log out</a></li>
                                </ul>
                            </li>
                        <?php } else { ?>
                                <li class="nav-item"><a href="#" class="btn btn-outline-primary">Login</a></li>
                                <li class="nav-item"><a href="#" class="btn btn-outline-success ms-md-1 mt-md-0 mt-1">Sign Up</a></li>
                                <li class="nav-item"><a href="#" class="btn ms-md-1 mt-md-0 mt-1 px-0">
                                    <i class="fas fa-shopping-cart fa-md icon-link"></i>
                                </a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->

        <!-- Start Main Slideshow-->
        <div id="carouselExampleSlidesOnly" class="carousel slide bg-nav" data-bs-ride="carousel" data-bs-pause="false">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="assets/base-mellows/example-alpha.png" class="d-block mx-auto w-25" alt="Red Mellow with headphones">
                </div>
                <div class="carousel-item">
                    <img src="assets/base-mellows/example-bravo.png" class="d-block mx-auto w-25" alt="White Mellow with angel wings">`
                </div>
            </div>
        </div>
        <!-- End Main Slideshow-->
    </header>

    

</body>

</html>
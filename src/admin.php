<?php

$loggedIn = false;
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Mehdi El Khallouki">
    <meta name="description" content="A website where you can customize and order your own squishmellow">
    <title>My Mellow My Admin</title>
    <link rel="icon" href="assets/favicon.svg">
    <link rel="stylesheet" href="stylesheets/admin.css">
    <script type="module" src="scripts/script.js"></script>
</head>
<?php if (!$loggedIn) { ?>
<body class="d-flex justify-content-center">
    <div class="text-center">

        <header>
            <img src="assets/logo-admin.png" class="w-25 mt-5" alt="Admin logo">
        </header>

        <form class="mt-5 w-50 m-auto">

            <div>
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username">
            </div>

            <div>
                <label for="password" class="form-label mt-2">Password:</label>
                <input type="password" class="form-control" id="password">
            </div>

            <button type="submit" class="btn btn-info mt-2">Log in</button>
        </form>

    </div>
</body>

<?php } else { ?>
<body class="d-flex">

    <!-- Side Navbar -->
    <nav class="bg-black text-white py-2 px-3 d-none d-sm-block" style="width: 250px;">
        <ul class="nav flex-column">
            <li class="navbar-brand mb-3">
                <img src="assets/logo-admin.png" class="w-100" alt="Admin logo">
            </li>
            <li class="btn-group-vertical">
                <a class="btn btn-outline-info" href="#">Home</a>
                <a class="btn btn-info">Landing Page</a>
                <a class="btn btn-info">Coupons</a>
                <a class="btn btn-info">Orders</a>
                <a class="btn btn-info">Accounts</a>
            </li>
        </ul>
    </nav>



    <main>
        <!-- Mobile navbar-->
        <a class="btn btn-outline-danger d-sm-none mb-3" data-bs-toggle="offcanvas" href="#offcanvasNav" role="button"
            aria-controls="offcanvasNav">
            <i class="fas fa-bars"></i>
        </a>
    
    <div class="offcanvas offcanvas-start bg-black text-white" tabindex="-1" id="offcanvasNav">
        <div class="offcanvas-header">
            <img src="assets/logo-admin.png" class="w-50 m-auto" alt="Admin logo" style="padding-left: 30px;">
            <button type="button" class="btn btn-close m-0" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body m-auto">
            <li class="btn-group-vertical align-items-center">
                <a class="btn btn-outline-info" href="#">Home</a>
                <a class="btn btn-info">Landing Page</a>
                <a class="btn btn-info">Coupons</a>
                <a class="btn btn-info">Orders</a>
                <a class="btn btn-info">Accounts</a>
            </li>
        </div>
    </div>
    <!-- Main Content -->
    <div class="container">
        <h1 class="text-white">Welcome Admin!</h1>
        <p class="text-white">There are no new orders today :)</p>
    </div>

</main>
<?php } ?>
</body>

</html>

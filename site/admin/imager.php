<?php

session_start();
if (!isset($_SESSION['AdminID'])) {
    header("Location: login.php");
    die;
}

require "connector.php";

$sql = "SELECT Name, Filepath FROM Accessories";
$query = $pdo->query($sql);
$accessories = $query->fetchAll();

include "head.php";
?>

<head>
    <link rel="stylesheet" href="../stylesheets/dist/imager.css">
    <script src="../scripts/dist/selector.js" defer></script>
</head>

<body>
    <div id="base-image-container">
        <img id="base-image" src="#" alt="Base Image">
        <img id="accessory" src="#" alt="Accessory">
    </div>
    <button id="generate-button" class="btn">Generate Image</button>
    <button id="upload-btn" class="btn btn-outline-success">Upload</button>
    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
        <input type="radio" class="btn-check" name="btnradio" id="alpha" autocomplete="off" checked="">
        <label class="btn btn-outline-primary" for="alpha">Basic</label>
        <input type="radio" class="btn-check" name="btnradio" id="bravo" autocomplete="off" checked="">
        <label class="btn btn-outline-primary" for="bravo">Belly</label>
        <input type="radio" class="btn-check" name="btnradio" id="charlie" autocomplete="off" checked="">
        <label class="btn btn-outline-primary" for="charlie">DX</label>
    </div>

    <div class="dropdown m-2">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="../assets/pallet/default.png" width="40">
        </button>
        <ul class="dropdown-menu">
            <li><button class="dropdown-item" id="red"><img src="../assets/pallet/red.png" width="40"></button></li>
            <li><button class="dropdown-item" id="blue"><img src="../assets/pallet/blue.png" width="40"></button></li>
            <li><button class="dropdown-item" id="pink"><img src="../assets/pallet/pink.png" width="40"></button></li>
            <li><button class="dropdown-item" id="black"><img src="../assets/pallet/black.png" width="40"></button></li>
            <li><button class="dropdown-item" id="green"><img src="../assets/pallet/green.png" width="40"></button></li>
            <li><button class="dropdown-item" id="orange"><img src="../assets/pallet/orange.png" width="40"></button></li>
            <li><button class="dropdown-item" id="yellow"><img src="../assets/pallet/yellow.png" width="40"></button></li>
            <li><button class="dropdown-item" id="purple"><img src="../assets/pallet/purple.png" width="40"></button></li>
            <li><button class="dropdown-item" id="white"><img src="../assets/pallet/white.png" width="40"></button></li>
        </ul>
    </div>
    <select class="form-select" aria-label="Default select example">
    <?php foreach ($accessories as $accessory) { ?>
        <option value="<?= $accessory['Filepath'] ?>"><?= $accessory['Name'] ?></option>
    <?php } ?>
    </select>

    <a href="pilot.php" class="btn btn-outline-primary"><i class="fas fa-arrow-left"></i> Go Back</a>
    <div id="result"></div>
    <script src="../scripts/dist/engine.js"></script>
</body>

</html>
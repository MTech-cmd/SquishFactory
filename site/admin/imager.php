<?php

include "head.php";
?>

<head>
    <link rel="stylesheet" href="../stylesheets/dist/imager.css">
</head>

<body>
    <div id="base-image-container">
        <img id="base-image" src="../assets/base-mellows/alpha/pink.png" alt="Base Image">
        <img id="accessory" src="../assets/accessories/headphones.png" alt="Accessory">
    </div>
    <button id="generate-button" class="btn">Generate Image</button>
    <button id="upload-btn-admin" class="btn btn-outline-success">Upload</button>
    <div id="result"></div>
    <script src="../scripts/dist/engine.js"></script>
</body>
</html>

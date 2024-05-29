<?php 

include "head.php";
?>
</head>
    <link rel="stylesheet" href="../stylesheets/dist/imager.css">
    <script src="../scripts/dist/selector.js" defer></script>
</head>

<body>
    <div id="base-image-container">
        <img id="base-image" src="../assets/base-mellows/alpha/pink.png" alt="Base Image">
        <img id="accessory" src="../assets/accessories/headphones.png" alt="Accessory">
    </div>
    <button id="generate-button" class="btn">Generate Image</button>
    <button id="upload-btn" class="btn btn-outline-success">Upload</button>
    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
        <input type="radio" class="btn-check" name="btnradio" id="body-alpha" autocomplete="off" checked="">
        <label class="btn btn-outline-primary" for="body-alpha">Basic</label>
        <input type="radio" class="btn-check" name="btnradio" id="body-bravo" autocomplete="off" checked="">
        <label class="btn btn-outline-primary" for="body-bravo">Belly</label>
        <input type="radio" class="btn-check" name="btnradio" id="body-charlie" autocomplete="off" checked="">
        <label class="btn btn-outline-primary" for="body-charlie">DX</label>
    </div>
    <div id="result"></div>
    <script src="../scripts/dist/engine.js"></script>
</body>

</html>

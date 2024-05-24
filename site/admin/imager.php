<?php

include "head.php"
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customize Your Mellow</title>
    <style>
        body {
            max-width: 650px;
            margin: 0 auto;
            padding: 20px;
        }

        #mellow-container {
            max-width: 650px;
            position: relative;
        }

        #mellow-container img {
            max-width: 100%;
        }

        #options {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Customize Your Mellow</h1>
    
    <div id="mellow-container">
        <img id="mellow-image" src="" alt="Mellow" />
        <img id="accessory-image" src="" alt="Accessory" draggable="true" ondragstart="drag(event)" />
    </div>

    <div id="options">
        <h2>Choose Mellow Color:</h2>
        <select id="mellow-color">
            <option value="red">Red</option>
            <option value="green">Green</option>
            <option value="blue">Blue</option>
        </select>

        <h2>Choose Accessory:</h2>
        <select id="accessory-type">
            <option value="devil_horns">Top Hat</option>
            <option value="devil_wings">Halo</option>
        </select>
    </div>

    <button id="generate-image">Generate Image</button>
    <canvas id="canvas" style="display: none;"></canvas>

    <script src="../scripts/src/engine.js"></script> <!-- JavaScript file for dynamic behavior -->
</body>
</html>

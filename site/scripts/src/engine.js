document.addEventListener('DOMContentLoaded', (event) => {
    const accessory = document.getElementById('accessory');
    let offsetX,
        offsetY;
    let isDragging = false;

    accessory.addEventListener('click', (e) => {
        if (!isDragging) {
            offsetX = e.clientX - parseInt(window.getComputedStyle(accessory).left, 10);
            offsetY = e.clientY - parseInt(window.getComputedStyle(accessory).top, 10);
            document.addEventListener('mousemove', mouseMoveHandler);
            isDragging = true;
        } else {
            document.removeEventListener('mousemove', mouseMoveHandler);
            isDragging = false;
        }
    });

    function mouseMoveHandler(e) {
        accessory.style.left = (e.clientX - offsetX) + 'px';
        accessory.style.top = (e.clientY - offsetY) + 'px';
    }
});

document.getElementById('generate-button').addEventListener('click', () => {
    const baseImage = document.getElementById('base-image');
    const accessory = document.getElementById('accessory');
    const resultContainer = document.getElementById('result');

    // Create a canvas with the same size as the images container
    const container = document.getElementById('base-image-container');
    const canvas = document.createElement('canvas');
    canvas.width = container.clientWidth;
    canvas.height = container.clientHeight;
    const ctx = canvas.getContext('2d');

    // Get the position of the accessory
    const accessoryX = parseInt(accessory.style.left, 10) || 0;
    const accessoryY = parseInt(accessory.style.top, 10) || 0;

    // Draw the accessory image
    ctx.drawImage(accessory, accessoryX, accessoryY);

    // Draw the base image in the center
    const baseImageX = (container.clientWidth - baseImage.width) / 2;
    const baseImageY = (container.clientHeight - baseImage.height) / 2;
    ctx.drawImage(baseImage, baseImageX, baseImageY);

    // Get the final image data URL and display it
    const finalImage = canvas.toDataURL('image/png');
    const img = new Image();
    img.src = finalImage;
    img.style.maxWidth = '100%'; // Ensure the generated image respects the container's width
    img.style.maxHeight = '100%'; // Ensure the generated image respects the container's height
    resultContainer.innerHTML = '';
    resultContainer.appendChild(img);

    // Assign finalImage to a global variable for later use in the upload function
    window.generatedImage = finalImage;
});

// Determine whether the upload is from an admin panel or not
document.getElementById('upload-btn-admin').addEventListener('click', () => {
    if (window.generatedImage) {
        uploadImage(window.generatedImage, true);
    } else {
        console.error('No image generated yet.');
    }
});

document.getElementById('upload-btn').addEventListener('click', () => {
    if (window.generatedImage) {
        uploadImage(window.generatedImage, false);
    } else {
        console.error('No image generated yet.');
    }
});

function uploadImage(imageDataUrl, isAdmin) {
    // Convert the data URL to a Blob object
    const byteString = atob(imageDataUrl.split(',')[1]);
    const mimeString = imageDataUrl.split(',')[0].split(':')[1].split(';')[0];
    const arrayBuffer = new ArrayBuffer(byteString.length);
    const intArray = new Uint8Array(arrayBuffer);

    for (let i = 0; i < byteString.length; i++) {
        intArray[i] = byteString.charCodeAt(i);
    }

    const blob = new Blob([intArray], { type: mimeString });

    // Prepare FormData
    const formData = new FormData();
    formData.append('image', blob, 'generated.png');
    formData.append('isAdmin', isAdmin);

    // Send the image to the PHP script
    const scriptLocation = document.currentScript.src; // Get the current script location
    const uploadPath = new URL('../../upload.php', scriptLocation).href; // Construct the path to upload.php

    fetch(uploadPath, {
        method: 'POST',
        body: formData,
    })
        .then(response => response.text())
        .then(result => {
            console.log('Success:', result);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    if (isAdmin) {
        window.location.href = "pilot.php";
    } else window.location.href = "cart.php";
}

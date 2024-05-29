document.addEventListener('DOMContentLoaded', (event) => {
    const accessory = document.getElementById('accessory');
    if (!accessory) {
        console.error('Element with ID "accessory" not found.');
        return;
    }

    let offsetX, offsetY;
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

    if (!baseImage || !accessory || !resultContainer) {
        console.error('One or more required elements not found.');
        return;
    }

    const container = document.getElementById('base-image-container');
    const canvas = document.createElement('canvas');
    canvas.width = container.clientWidth;
    canvas.height = container.clientHeight;
    const ctx = canvas.getContext('2d');

    const accessoryX = parseInt(accessory.style.left, 10) || 0;
    const accessoryY = parseInt(accessory.style.top, 10) || 0;

    ctx.drawImage(accessory, accessoryX, accessoryY);

    const baseImageX = (container.clientWidth - baseImage.width) / 2;
    const baseImageY = (container.clientHeight - baseImage.height) / 2;
    ctx.drawImage(baseImage, baseImageX, baseImageY);

    const finalImage = canvas.toDataURL('image/png');
    const img = new Image();
    img.src = finalImage;
    img.style.maxWidth = '100%';
    img.style.maxHeight = '100%';
    resultContainer.innerHTML = '';
    resultContainer.appendChild(img);

    window.generatedImage = finalImage;
});

document.getElementById('upload-btn').addEventListener('click', () => {
    if (window.generatedImage) {
        uploadImage(window.generatedImage);
    } else {
        console.error('No image generated yet.');
    }
});

function uploadImage(imageDataUrl) {
    console.log('Uploading image,');

    const byteString = atob(imageDataUrl.split(',')[1]);
    const mimeString = imageDataUrl.split(',')[0].split(':')[1].split(';')[0];
    const arrayBuffer = new ArrayBuffer(byteString.length);
    const intArray = new Uint8Array(arrayBuffer);

    for (let i = 0; i < byteString.length; i++) {
        intArray[i] = byteString.charCodeAt(i);
    }

    const blob = new Blob([intArray], { type: mimeString });

    const formData = new FormData();
    formData.append('image', blob, 'generated.png');

    for (let pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }

    const uploadPath = 'upload.php';

    console.log('Upload path:', uploadPath);

    fetch(uploadPath, {
        method: 'POST',
        body: formData,
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.text();
        })
        .then(result => {
            console.log('Success:', result);
            window.location.href = "redirect.php";
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
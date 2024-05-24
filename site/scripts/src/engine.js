document.addEventListener('DOMContentLoaded', (event) => {
    const accessory = document.getElementById('accessory');
    let offsetX, offsetY;
    let isDragging = false;

    accessory.addEventListener('click', (e) => {
        if (!isDragging) {
            offsetX = e.clientX - parseInt(window.getComputedStyle(accessory).left);
            offsetY = e.clientY - parseInt(window.getComputedStyle(accessory).top);
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
    const accessoryX = parseInt(accessory.style.left) || 0;
    const accessoryY = parseInt(accessory.style.top) || 0;

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
});

document.addEventListener("DOMContentLoaded", function () {
    const mellowContainer = document.getElementById("mellow-container");
    const mellowImage = document.getElementById("mellow-image");
    const accessoryImage = document.getElementById("accessory-image");
    const mellowColorSelect = document.getElementById("mellow-color");
    const accessorySelect = document.getElementById("accessory-type");
    const generateImageButton = document.getElementById("generate-image");
    const canvas = document.getElementById("canvas");
    const ctx = canvas.getContext("2d");

    mellowColorSelect.addEventListener("change", function () {
        const selectedColor = mellowColorSelect.value;
        mellowImage.src = `../assets/base-mellows/alpha/${selectedColor}.png`;
    });

    accessorySelect.addEventListener("change", function () {
        const selectedAccessory = accessorySelect.value;
        accessoryImage.src = `../assets/accessories/${selectedAccessory}.png`;
    });

    function drag(ev) {
        ev.dataTransfer.setData("text", ev.target.id);
    }

    mellowContainer.addEventListener("dragover", function (ev) {
        ev.preventDefault();
    });

    mellowContainer.addEventListener("drop", function (ev) {
        ev.preventDefault();
        const data = ev.dataTransfer.getData("text");
        const draggableElement = document.getElementById(data);
        const offsetX = ev.clientX - mellowContainer.offsetLeft;
        const offsetY = ev.clientY - mellowContainer.offsetTop;
        draggableElement.style.position = "absolute";
        draggableElement.style.left = offsetX + "px";
        draggableElement.style.top = offsetY + "px";
    });

    generateImageButton.addEventListener("click", function () {
        const mellowBounds = mellowContainer.getBoundingClientRect();
        const accessoryBounds = accessoryImage.getBoundingClientRect();

        canvas.width = mellowBounds.width;
        canvas.height = mellowBounds.height;

        ctx.clearRect(0, 0, canvas.width, canvas.height);

        ctx.drawImage(mellowImage, 0, 0, mellowBounds.width, mellowBounds.height);

        const offsetX = accessoryBounds.left - mellowBounds.left;
        const offsetY = accessoryBounds.top - mellowBounds.top;

        ctx.drawImage(accessoryImage, offsetX, offsetY, accessoryBounds.width, accessoryBounds.height);

        // Convert canvas to image and display or do further processing
        const imageURL = canvas.toDataURL();
        const generatedImage = new Image();
        generatedImage.src = imageURL;

        document.body.appendChild(generatedImage);
    });
});
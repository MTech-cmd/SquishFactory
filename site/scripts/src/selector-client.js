const baseImage = document.getElementById("base-image");
const accessoryImage = document.getElementById("accessory");
const colorButtons = document.querySelectorAll(".dropdown-item");
const bodyTypeRadios = document.querySelectorAll("input[name='btnradio']");
const accessorySelect = document.querySelector(".form-select");
const generateButton = document.getElementById("generate-button");

let selectedColor = "red";
let selectedBodyType = "charlie";
let selectedAccessory = `.${accessorySelect.value}`;

// Function to update images
function updateImages() {
    baseImage.src = `./assets/base-mellows/${selectedBodyType}/${selectedColor}.png`;
    accessoryImage.src = selectedAccessory;
}

// Event listeners for color buttons
colorButtons.forEach(button => {
    button.addEventListener("click", function () {
        selectedColor = button.id;
        updateImages();
    });
});

// Event listeners for body type radio buttons
bodyTypeRadios.forEach(radio => {
    radio.addEventListener("change", function () {
        selectedBodyType = radio.id;
        updateImages();
    });
});

// Event listener for accessory select
accessorySelect.addEventListener("change", function () {
    selectedAccessory = `.${accessorySelect.value}`;
    updateImages();
});

// Generate button click event
generateButton.addEventListener("click", function () {
    updateImages();
});

// Initial image update
updateImages();


function getCurrentSelectedRadio(callback) {
    // Select all radio buttons with the name 'btnradio'
    const radioButtons = document.querySelectorAll('input[name="btnradio"]');

    // Iterate through the NodeList to find the checked radio button
    let selectedRadio = null;
    radioButtons.forEach((radio) => {
        if (radio.checked) {
            selectedRadio = {
                id: radio.id,
                label: document.querySelector(`label[for="${radio.id}"]`).textContent
            };
        }
    });

    // Invoke the callback function with the selected radio button
    if (callback && typeof callback === 'function') {
        callback(selectedRadio);
    }

    return selectedRadio;
}

// Example usage:
function onRadioChange(selectedRadio) {
    if (selectedRadio) {
        console.log("Selected radio button ID:", selectedRadio.id);
        console.log("Selected radio button label:", selectedRadio.label);
    } else {
        console.log("No radio button is selected.");
    }
}

// Initial invocation
getCurrentSelectedRadio(onRadioChange);

// Event listener to invoke the function whenever a radio button is clicked
document.querySelectorAll('input[name="btnradio"]').forEach((radio) => {
    radio.addEventListener('change', () => {
        getCurrentSelectedRadio(onRadioChange);
    });
});

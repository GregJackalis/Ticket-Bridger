
function validateNumber1(){
    var ticketsInput = document.getElementById("ticketsInput1");
    var ticketsError = document.getElementById("ticketsError1");
    var ticketsValue = parseInt(ticketsInput.value);

    if (ticketsValue <= 0 || isNaN(ticketsValue)) {
        ticketsError.innerHTML = "Please enter a valid number.";
        ticketsInput.value = "";
        return false;
    } else {
        ticketsError.innerHTML = "";
        return true;
    }
}

function validateNumber2(){
    var ticketsInput = document.getElementById("ticketsInput2");
    var ticketsError = document.getElementById("ticketsError2");
    var ticketsValue = parseInt(ticketsInput.value);

    if (ticketsValue <= 0 || isNaN(ticketsValue)) {
        ticketsError.innerHTML = "Please enter a valid number.";
        ticketsInput.value = "";
        return false;
    } else {
        ticketsError.innerHTML = "";
        return true;
    }
}

function validateNumberOfTickets(){
    var ticketsInput = document.getElementById("ticketsInput");
    var ticketsError = document.getElementById("ticketsError");
    var ticketsValue = parseInt(ticketsInput.value);

    if (ticketsValue <= 0 || isNaN(ticketsValue)) {
        ticketsError.innerHTML = "Please enter a valid number.";
        ticketsInput.value = "";
        return false;
    } else {
        ticketsError.innerHTML = "";
        return true;
    }
}

function displayMessage() {
    const urlParams = new URLSearchParams(window.location.search);
    const success = urlParams.get('success');

    if (success === 'true') {
        alert("Ticket uploaded successfully!");
        clearForm();
    } else if (success === 'false') {
        alert("Oops! Something went wrong. Please try again.");
    }
}

function clearForm() {
    var form = document.querySelector('.UploadForm');
    var inputs = form.getElementsByTagName("input");

    for(var i=0; i < inputs.length-1; i++){
        inputs[i].value = '';
    }
}
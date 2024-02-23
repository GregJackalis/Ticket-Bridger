document.addEventListener('DOMContentLoaded', function() {
    // Wait for the DOM content to be fully loaded before attaching the event listener
    var submitBtn = document.getElementById('submitBtn');

    submitBtn.addEventListener('click', function (event) {
        event.preventDefault();
        
        // Code to handle the click event
        // Make the AJAX request and handle the JSON response here
        var xhr = new XMLHttpRequest();
        xhr.open('POST', "../Middle End/main.php", true);
        xhr.setRequestHeader('Content-Type', 'application/json');

        console.log(xhr.responseText)

        var errorMessagesElement = document.getElementById('errorMessages');
        xhr.onreadystatechange = function() {
            if (xhr.status === 200) {
                var response = xhr.responseText;

                for (error of response.errors) {
                    var headerElement = document.createElement('h2');
                    headerElement.textContent = response.errors[error];
                    errorMessagesElement.appendChild(headerElement);
                }
                console.log(response);
            } else {
                console.error('Request failed with status:', xhr.status);
            }
        };
        xhr.send();
    });

});
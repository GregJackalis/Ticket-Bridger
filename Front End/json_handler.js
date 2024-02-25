var phpElement = document.getElementById('phpResponse');
var newEl = document.createElement('div');

// FOR SIGN UP
$(function() {
    $("#submitBtn").click(function(event) {
        console.log("register button pressed!!")

        phpElement.innerHTML = ""; // Clear previous content
        newEl.innerHTML = ""; // Clear previous content
        event.preventDefault();

        // Serialize form data
        var formData = $("#signUpForm").serialize();
        console.log(formData);

        // Send data to server using AJAX
        $.post('../Middle End/main.php', formData, function(response) {
            console.log(response); // Log response for debugging

            if (response.status == 'success') {
                newEl.innerHTML = response.message;
            } else {
                var header = document.createElement('h2');
                header.innerHTML = "Errors while Signing up:<br>";
                phpElement.appendChild(header);
                newEl.innerHTML = "<p>" + response.message + "</p><br>";
                for (var key in response.errors) {
                    if (response.errors.hasOwnProperty(key) && response.errors[key] !== null) {
                        newEl.innerHTML += "<p>" + response.errors[key] + "</p><br>";
                    }
                }
            }

            phpElement.appendChild(newEl);
        });
    });
});

// ----------------------------------------------------------------------------------------------------------------------------

// FOR LOGIN
$(function() {
    $("#loginBtn").click(function(event) {
        console.log("login button pressed!!")
        phpElement.innerHTML = ""; // Clear previous content
        newEl.innerHTML = ""; // Clear previous content
        event.preventDefault();

        // Serialize form data
        var formData = $("#loginForm").serialize();
        console.log(formData)

        // Send data to server using AJAX
        $.post('../Middle End/main.php', formData, function(response) {
            console.log(response); // Log response for debugging

            if (response.status == 'success') {
                newEl.innerHTML = response.message;
            } else {
                var header = document.createElement('h2');
                header.innerHTML = "Errors while Logging in:<br>"; // Changed header text
                phpElement.appendChild(header);
                newEl.innerHTML = "<p>" + response.message + "</p><br>";
                for (var key in response.errors) {
                    if (response.errors.hasOwnProperty(key) && response.errors[key] !== null) {
                        newEl.innerHTML += "<p>" + response.errors[key] + "</p><br>";
                    }
                }
            }

            phpElement.appendChild(newEl);
        });
    });
});

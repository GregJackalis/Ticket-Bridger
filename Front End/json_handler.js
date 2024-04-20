var phpElement = document.getElementById('phpResponse');
phpElement.classList.add('wrapper');
var newEl = document.createElement('div');
const closeGetStarted = document.querySelectorAll('.getStarted');
const carticon = document.querySelector('.carticon');
const usericon = document.querySelector('.usericon');
const sellButton = document.querySelector('.sellButton');
var errMessage = false; // this is used in order to check whether the message is for an error, 
// so that the appropriate class will be used

// FOR SIGN UP
$(function() {
    $("#submitBtn").click(function(event) {
        console.log("register button pressed!!")

        newEl.innerHTML = ""; // Clear previous content
        event.preventDefault();

        // Serialize form data
        var formData = $("#signUpForm").serialize();
        console.log(formData);

        // Send data to server using AJAX
        $.post('../Middle End/main.php', formData, function(response) {
            console.log(response); // Log response for debugging

            if (response.status == 'register success') {
                newEl.innerHTML = '<p class="popup-font">Registered Successfully!</p>';
                phpElement.classList.add('message');
                phpElement.classList.remove('active');
            } else {
                // var header = document.createElement('h2');
                // header.innerHTML = "Errors while Signing up:<br>";
                // phpElement.appendChild(header);
                // newEl.innerHTML = "<p>" + response.message + "</p><br>";
                // for (var key in response.errors) {
                //     if (response.errors.hasOwnProperty(key) && response.errors[key] !== null) {
                //         newEl.innerHTML += "<p>" + response.errors[key] + "</p><br>";
                //     }
                // }
                newEl.innerHTML = '<p class="popup-font">Email must be of valid type!<br>';
                newEl.innerHTML += 'Password must contain at least a number, an uppercase character,'
                newEl.innerHTML += ' a lowercase character, a special character, and its length <br>to be more than 8 characters.</p>';
                phpElement.classList.add('error-message');
                errMessage = true;
            }
            phpElement.appendChild(newEl);
        });
        phpElement.classList.add('active');
        phpElement.classList.add('active-popup');
    });
});

// ----------------------------------------------------------------------------------------------------------------------------

// FOR LOGIN
$(function() {
    $("#loginBtn").click(function(event) {
        console.log("login button pressed!!")

        newEl.innerHTML = ""; // Clear previous content
        event.preventDefault();

        // Serialize form data
        var formData = $("#loginForm").serialize();
        console.log(formData)

        // Send data to server using AJAX
        $.post('../Middle End/main.php', formData, function(response) {
            console.log(response); // Log response for debugging
            
            if (response.status == 'missing cred error') {
                newEl.innerHTML = '<p class="popup-font">Missing Credentials!</p>';
                phpElement.classList.add('message');

            } else if (response.status == 'no records') {
                    newEl.innerHTML = '<p class="popup-font">No records with that email found!</p>';
                    phpElement.classList.add('message');

            } else if (response.status == "login error") {
                newEl.innerHTML = '<p class="popup-font">Invalid Credentials!</p>';
                phpElement.classList.add('message');
                errMessage = true;

                // FOR SUCCESS CASE IN LOGIN PHASE
            } else if (response.status == 'login success') {
                newEl.innerHTML = `<p class="popup-font">Welcome back, ${response.message}!</p>`;
                phpElement.classList.add('message');
                carticon.classList.add('active');
                usericon.classList.add('active');
                sellButton.classList.add('active');

                closeGetStarted.forEach(function(el){

                    el.classList.add('close');

                });
                removeActive();
               
            } 

            phpElement.appendChild(newEl);
        });
        phpElement.classList.add('active');
        phpElement.classList.add('active-popup');
    });
});

$('.icon-close').click(()=> {
    phpElement.classList.remove('active');
    phpElement.classList.remove('active-popup');
    if (errMessage == true) {
        errMessage = false;
        phpElement.classList.remove('error-message');
    } else {
        phpElement.classList.remove('message');
    }
  });
  

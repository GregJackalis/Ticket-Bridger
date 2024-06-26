var phpElement = document.getElementById('phpResponse');
phpElement.classList.add('wrapper');
var newEl = document.createElement('div');
const closeGetStarted = document.querySelectorAll('.getStarted');

const usericon = document.querySelector('.usericon');
const sellButton = document.querySelector('.sellButton');
var errMessage = false; // this is used in order to check whether the message is for an error, 
// so that the appropriate class will be used

// FOR SIGN UP
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('submitBtn').addEventListener('click', async function(event) {
        console.log("register button pressed!!");
        
        newEl.innerHTML = ""; // Clear previous content
        event.preventDefault();

        // Serialize form data
        var formData = new FormData(document.getElementById('signUpForm'));
        var formDataObject = {};
        formData.forEach((value, key) => { formDataObject[key] = value; });
        var jsonString = JSON.stringify(formDataObject);
        console.log(jsonString);

        if (window.location.href.includes("Front%20End")) {
            var url = "../Middle End/main.php";
        } else if (window.location.href.includes("index.php") || window.location.href.includes("")) {
            var url = "Middle End/main.php";
        } 

        try {
            // Send data to server using fetch
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: jsonString
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const responseData = await response.text();
            console.log(responseData); // Log response for debugging

            const data = JSON.parse(responseData);

            console.log(data.status);


            // var backRes = JSON.parse(response.text);
            // console.log(backRes);

            if (data.status === 'register success') {
                newEl.innerHTML = '<p class="popup-font">Registered Successfully!</p>';
                phpElement.classList.add('message');
                phpElement.classList.remove('active');
            } else {
                newEl.innerHTML = '<p class="popup-font">Email must be of valid type!<br>';
                newEl.innerHTML += 'Password must contain at least a number, an uppercase character,';
                newEl.innerHTML += ' a lowercase character, a special character, and its length <br>to be more than 8 characters. <br>';
                newEl.innerHTML += ' Only english characters, underscore, and dashes are allowed on the username. </p>';
                phpElement.classList.add('error-message');
                errMessage = true;
            }
            phpElement.appendChild(newEl);
        } catch (error) {
            console.error("Error:", error);
            newEl.innerHTML = `<p class="popup-font">An error occurred: ${error.message}</p>`;
            phpElement.classList.add('error-message');
            phpElement.appendChild(newEl);
        }

        phpElement.classList.add('active');
        phpElement.classList.add('active-popup');
    });
});





// $(function() {
//     $("#submitBtn").click(function(event) {
//         console.log("register button pressed!!")

//         newEl.innerHTML = ""; // Clear previous content
//         event.preventDefault();

//         // Serialize form data
//         var formData = $("#signUpForm").serialize();
//         console.log(formData);

//         // Send data to server using AJAX
//         $.post('../Middle End/main.php', formData, function(response) {
//             console.log(response); // Log response for debugging

//             if (response.status == 'register success') {
//                 newEl.innerHTML = '<p class="popup-font">Registered Successfully!</p>';
//                 phpElement.classList.add('message');
//                 phpElement.classList.remove('active');
//             } else {
//                 // var header = document.createElement('h2');
//                 // header.innerHTML = "Errors while Signing up:<br>";
//                 // phpElement.appendChild(header);
//                 // newEl.innerHTML = "<p>" + response.message + "</p><br>";
//                 // for (var key in response.errors) {
//                 //     if (response.errors.hasOwnProperty(key) && response.errors[key] !== null) {
//                 //         newEl.innerHTML += "<p>" + response.errors[key] + "</p><br>";
//                 //     }
//                 // }
//                 newEl.innerHTML = '<p class="popup-font">Email must be of valid type!<br>';
//                 newEl.innerHTML += 'Password must contain at least a number, an uppercase character,'
//                 newEl.innerHTML += ' a lowercase character, a special character, and its length <br>to be more than 8 characters.</p>';
//                 newEl.innerHTML += ' <br> If all the previous is done then email Already used.</p>';
//                 phpElement.classList.add('error-message');
//                 errMessage = true;
//             }
//             phpElement.appendChild(newEl);
//         });
//         phpElement.classList.add('active');
//         phpElement.classList.add('active-popup');
//     });
// });

// ----------------------------------------------------------------------------------------------------------------------------

// FOR LOGIN
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('loginBtn').addEventListener('click', async function(event) {
        console.log("login button pressed!!")

        newEl.innerHTML = ""; // Clear previous content
        event.preventDefault();

        // Serialize form data
        var formData = new FormData(document.getElementById('loginForm'));
        var formDataObject = {};
        formData.forEach((value, key) => { formDataObject[key] = value; });
        var jsonString = JSON.stringify(formDataObject);
        console.log(jsonString);

        if (window.location.href.includes("Front%20End")) {
            var url = "../Middle End/main.php";
        } else if (window.location.href.includes("index.php") || window.location.href.includes("")) {
            var url = "Middle End/main.php";
        } 

        try {
            // Send data to server using fetch
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: jsonString
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const responseData = await response.text();

            const data = JSON.parse(responseData);

            console.log(data); // Log response for debugging

            if (data.status === 'missing cred error') {
                newEl.innerHTML = '<p class="popup-font">Missing Credentials!</p>';
                phpElement.classList.add('message');
            } else if (data.status === 'no records') {
                newEl.innerHTML = '<p class="popup-font">No records with that email found!</p>';
                phpElement.classList.add('message');
            } else if (data.status === "login error") {
                newEl.innerHTML = '<p class="popup-font">Invalid Credentials!</p>';
                phpElement.classList.add('message');
                errMessage = true;
            } else if (data.status === 'login success') {
                newEl.innerHTML = `<p class="popup-font">Welcome back, ${data.message}!</p>`;
                phpElement.classList.add('message');
                usericon.classList.add('active');
                sellButton.classList.add('active');
                closeGetStarted.forEach(function(el){
                    el.classList.add('close');
                });
                removeActive();
            } 

            phpElement.appendChild(newEl);
        } catch (error) {
            console.error("Error:", JSON.stringify(error));
            // Handle errors here
        }

        phpElement.classList.add('active');
        phpElement.classList.add('active-popup');
    });
});


// FOR CLOSE BUTTON ON LOGIN/REGISTER FORMS
document.querySelectorAll('.icon-close').forEach(function(closeButton) {
    closeButton.addEventListener('click', function() {
        phpElement.classList.remove('active');
        phpElement.classList.remove('active-popup');
        if (errMessage) {
            errMessage = false;
            phpElement.classList.remove('error-message');
        } else {
            phpElement.classList.remove('message');
        }
    });
});




// $(function() {
//     $("#loginBtn").click(function(event) {
//         console.log("login button pressed!!")

//         newEl.innerHTML = ""; // Clear previous content
//         event.preventDefault();

//         // Serialize form data
//         var formData = $("#loginForm").serialize();
//         console.log(formData)

//         // Send data to server using AJAX
//         $.post('../Middle End/main.php', formData, function(response) {
//             console.log(response); // Log response for debugging
            
//             if (response.status == 'missing cred error') {
//                 newEl.innerHTML = '<p class="popup-font">Missing Credentials!</p>';
//                 phpElement.classList.add('message');

//             } else if (response.status == 'no records') {
//                     newEl.innerHTML = '<p class="popup-font">No records with that email found!</p>';
//                     phpElement.classList.add('message');

//             } else if (response.status == "login error") {
//                 newEl.innerHTML = '<p class="popup-font">Invalid Credentials!</p>';
//                 phpElement.classList.add('message');
//                 errMessage = true;

//                 // FOR SUCCESS CASE IN LOGIN PHASE
//             } else if (response.status == 'login success') {
//                 newEl.innerHTML = `<p class="popup-font">Welcome back, ${response.message}!</p>`;
//                 phpElement.classList.add('message');
                
//                 usericon.classList.add('active');
//                 sellButton.classList.add('active');

//                 closeGetStarted.forEach(function(el){

//                     el.classList.add('close');

//                 });
//                 removeActive();
               
//             } 

//             phpElement.appendChild(newEl);
//         });
//         phpElement.classList.add('active');
//         phpElement.classList.add('active-popup');
//     });
// });

// $('.icon-close').click(()=> {
//     phpElement.classList.remove('active');
//     phpElement.classList.remove('active-popup');
//     if (errMessage == true) {
//         errMessage = false;
//         phpElement.classList.remove('error-message');
//     } else {
//         phpElement.classList.remove('message');
//     }
//   });
  

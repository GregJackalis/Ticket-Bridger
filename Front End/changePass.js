//------------------------------------------------------------------------------------------------------------
// CODE FOR TAKING USER BACK TO WHERE THEY CAME FROM
//------------------------------------------------------------------------------------------------------------
const params = new URLSearchParams(window.location.search);
const goBack = params.get('from').replace(/"/g, ''); // Remove surrounding quotes

$("#goBackBtn").click(function(event) {
    if (goBack === "H") {
        window.location.href = "./home.php";
    } else if (goBack === "A") {
        window.location.href = "./about.php";
    } else if (goBack === "C") {
        window.location.href = "./contact.php";
    } else {
        window.location.href = "./editProfile.php";
    }
});


//------------------------------------------------------------------------------------------------------------
// FUNCTION WHICH HANDLES SUBMIT PROCESS OF THE CHANGE PASSWORD FORM
//------------------------------------------------------------------------------------------------------------
$(function() {
    $("#changePassForm").submit(function(event) {
        console.log("Form submitted!!");
        
        // Prevent the default form submission
        event.preventDefault();
        
        // Serialize form data
        var userEmail = $("#email").val();
        var oldPassword = $("#oldPass").val();
        var newPassword = $("#newPass").val();
        var reEnterPassword = $("#newPass2").val();

        // console.log("User Email: " + userEmail);
        // console.log("Old Password: " + oldPassword);
        // console.log("New Password: " + newPassword);
        // console.log("Re-Entered Password: " + reEnterPassword);

        var formData = {
            userEmail: userEmail,
            oldPassword: oldPassword,
            newPassword: newPassword,
            reEnterPassword: reEnterPassword,
            action: "changePass"
        };
        
        console.log("im almost there");

        // Send data to server using AJAX
        $.post('../Middle End/main.php', formData, function(response) {
            // Handle the response from the server
            console.log(response);
            showReply(response.message);

        }).fail(function(jqXHR, textStatus, errorThrown) {
            // Handle errors here
            console.error("Error:", textStatus, errorThrown);
        });
    });
});

//------------------------------------------------------------------------------------------------------------
// SHOW APPROPRIATE REPLY BASED ON BACK END'S RESPONSE
//------------------------------------------------------------------------------------------------------------
function showReply(reply) {
    // Remove all elements within the form
    const form = document.getElementById("changePassForm");
    const container = document.querySelector('.container');

    container.style.height = "393px";


    var removedElements = [];
    
    while (form.firstChild) {
        removedElements.push(form.removeChild(form.firstChild));
    }

    // Create an h2 element
    const h2 = document.createElement("h2");
    h2.style.marginTop = "135px";

    // Create a button element
    const btnAppear = document.createElement("button");

    btnAppear.classList.add(".reAppearBtn");
    
    // create a temp variable
    let txt;

    if (reply == "noEmail") {
        txt = "Invalid Email was Given!";
    } else if (reply == "invOld") {
        txt = "Invalid Credentials";
    } else if (reply == "noMatch") {
        txt = "Passwords don't Match!";
    } else if (reply == "invPass") {
        txt = "Password must contain at least a number, an uppercase character, a lowercase character, a special character, and its length to be more than 8 characters."
    } else if (reply == "passChanged") {
        txt = "Password was changed Successfully!";
    } else {
        txt = "We are very sorry, our servers couldn't be reached!";
    }

    h2.textContent = txt; // Replace with your desired text

    // Center the h2 element
    h2.style.textAlign = "center";

    // if credentials were correct, the button that is dynamically made will work as a "Go Back" button
    if (reply == "passChanged") {
        btnAppear.textContent = "Go Back to Previous Page";

        btnAppear.addEventListener('click', function() {
            if (goBack === "H") {
                window.location.href = "./home.php";
            } else if (goBack === "A") {
                window.location.href = "./about.php";
            } else if (goBack === "C") {
                window.location.href = "./contact.php";
            } else {
                window.location.href = "./editProfile.php";
            }
        })
    } else {
        btnAppear.textContent = "Re-Enter Credentials";
        btnAppear.addEventListener('click', function() {
            reappearElements(form, removedElements);
        }) 
    }
   
    // Append the h2 element to the form
    form.appendChild(h2);
    form.appendChild(btnAppear);
}

//------------------------------------------------------------------------------------------------------------
// RE APPEAR ELELEMENTS WHEN USERS WANTS TO TRY AGAIN
//------------------------------------------------------------------------------------------------------------
function reappearElements(form, elements) {
    while (form.firstChild) {
        form.removeChild(form.firstChild);
    }

    elements.forEach(function(element) {
        form.appendChild(element);
    });
}





//------------------------------------------------------------------------------------------------------------
// DROPDOWN MENU
//------------------------------------------------------------------------------------------------------------
const dropDownMn = document.querySelector(".dropDownMenu");
const userDropDown = document.querySelector(".userDropMenu");
const toggleBtn = document.querySelector(".toggleButton");
const toggleUserIcon= document.querySelector(".usericon");
const toggleBtnIcon = document.querySelector(".toggleButton i");

toggleBtn.onclick = function () {
    dropDownMn.classList.toggle("open");
    const isOpen = dropDownMn.classList.contains("open");
    userDropDown.classList.remove("open");
  
    toggleBtnIcon.classList = isOpen
      ? "fa-solid fa-xmark"
      : "fa-solid fa-bars";
  };

toggleUserIcon.onclick = function () {
    userDropDown.classList.toggle("open");
    dropDownMn.classList.remove("open");
    toggleBtnIcon.classList = "fa-solid fa-Bars";
  }

document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
      const linksWithAnimation = document.querySelectorAll('.navBar a, .dropDownMenu a');
      linksWithAnimation.forEach(link => {
        link.style.animation = ''; // Reset animation
      });
    }, 100);
  });
  
const toggleBtn = document.querySelector(".toggleButton");
const toggleBtnIcon = document.querySelector(".toggleButton i");
const dropDownMn = document.querySelector(".dropDownMenu");
const toggleUserIcon= document.querySelector(".usericon");
const userDropDown = document.querySelector(".userDropMenu");

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

     
const wrapper = document.querySelector('.wrapper');
const loginLink = document.querySelector('.login-link');
const registerLink = document.querySelector('.register-link');
const popUpButtons = document.querySelectorAll('.getStarted');
const iconClose = document.querySelector('.icon-close');

registerLink.addEventListener('click', ()=> {
  wrapper.classList.add('active');
});

loginLink.addEventListener('click', ()=> {
  wrapper.classList.remove('active');
});

popUpButtons.forEach(function(button){

  button.addEventListener('click', function(){

    wrapper.classList.add('active-popup');

  });

});

iconClose.addEventListener('click', ()=> {
   wrapper.classList.remove('active-popup');
});


const removeActive = function(){
  wrapper.classList.remove('active-popup');

}


document.addEventListener('DOMContentLoaded', () => {
  setTimeout(() => {
    const linksWithAnimation = document.querySelectorAll('.navBar a, .dropDownMenu a');
    linksWithAnimation.forEach(link => {
      link.style.animation = ''; // Reset animation
    });
  }, 100);
});

const sellonClick = document.getElementById('sellclick');
 
sellonClick.addEventListener('click', function() {
  // Redirect to another page (file) when the button is clicked

  if (window.location.href.includes("Front%20End")) {
    var url = "./sell.php";
  } else if (window.location.href.includes("index.php") || window.location.href.includes("")) {
    var url = "Front End/sell.php";
  } 

  window.location.href = url; // Change to the file you want to navigate to
});

    

//appear table for event results
document.addEventListener("DOMContentLoaded", function(){

    const table = document.getElementById("table");

    if (result !== undefined) {
      if (result){
        table.classList.remove("appear");
      } else {
        table.classList.add("appear");
    }
    }
    
});

// Check the URL
if (window.location.href.includes("index.php")) {
  var pageType = "H";
} else if (window.location.href.includes("about.php")) {
  var pageType = "A";
} else if (window.location.href.includes("contact.php")) {
  var pageType = "C";
} else {
  var pageType = "none";
}

// send parameter to change password for accurate re-direction of user
document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('forgotBtn').addEventListener('click', function() {
    var from = JSON.stringify(pageType);
                
    if (pageType == "H" || pageType == "none") {
      // Construct the URL with the JSON string as a parameter
      var url = "Front End/changePass.html?from=" + encodeURIComponent(from);
    } else {
      // Construct the URL with the JSON string as a parameter
      var url = "changePass.html?from=" + encodeURIComponent(from);
    }
    
    // Navigate to the constructed URL
    window.location.href = url;

  });
});

//   $("#forgotBtn").click(function(event) {
//       // Convert the array to JSON string
//       var from = JSON.stringify(pageType);
                
//       // Construct the URL with the JSON string as a parameter
//       var url = "./changePass.html?from=" + encodeURIComponent(from);

//       // Navigate to the constructed URL
//       window.location.href = url;
//   });
// });
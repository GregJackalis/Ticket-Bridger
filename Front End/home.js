const toggleBtn = document.querySelector(".toggleButton");
      const toggleBtnIcon = document.querySelector(".toggleButton i");
      const dropDownMn = document.querySelector(".dropDownMenu");

      toggleBtn.onclick = function () {
        dropDownMn.classList.toggle("open");
        const isOpen = dropDownMn.classList.contains("open");

        toggleBtnIcon.classList = isOpen
          ? "fa-solid fa-xmark"
          : "fa-solid fa-bars";
      };


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


document.addEventListener('DOMContentLoaded', () => {
  setTimeout(() => {
    const linksWithAnimation = document.querySelectorAll('.navBar a, .dropDownMenu a');
    linksWithAnimation.forEach(link => {
      link.style.animation = ''; // Reset animation
    });
  }, 100);
});
    
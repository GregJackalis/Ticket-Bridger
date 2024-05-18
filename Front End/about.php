<?php
session_start();

if (!isset($_SESSION['loggedIn'])) {
  $_SESSION['loggedIn'] = 'nah';
}

include 'PHPtoJS.php';

if ($_SESSION['loggedIn'] == 'ye') {
  addClassesIcons();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- LINK FOR AJAX SUPPORT (AKA json_handler.js SCRIPT FOR HANDLING COMMUNICATION) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- ---------------------------------------------------------------------- -->

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="about.css" />
  <link rel="stylesheet" type="text/css" href="footer.css" />
  <link rel="stylesheet" href="ourTeam.css" />
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="stylesheet" href="home.css" />
  <title>Ticket Bridger</title>
</head>

<body class="AboutPage">
  <header>
    <div class="navBar">
      <div class="logo">
        <img src="Images/LogoImage.png" alt="logoImage" onclick="window.location.href='../index.php';" />
      </div>
      <ul class="links">
        <li><a href="../index.php">Home</a></li>
        <li><a href="about.php">About Us</a></li>
        <li><a href="contact.php">Contact Us</a></li>
      </ul>
      <div class="actionButtons">
        <button class="getStarted">Get Started</button>
        <i class="usericon fa-solid fa-user"></i>
        <button class="sellButton" id="sellclick">Sell</button>
        <div class="toggleButton">
          <i class="fa-solid fa-bars"> </i>
        </div>
      </div>
    </div>

    <div class="userDropMenu">
      <li><a href="editProfile.php">Profile</a></li>
      <li><a href="#" id="Logout">Logout</a></li>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('Logout').addEventListener('click', function() {
          fetch('tempLogout.php', {
              method: 'POST'
          })
          .then(response => {
            if (response.ok) {
              window.location.href = '../index.php';
            } else {
              return response.text().then(text => { throw new Error(text) });
            }
          })
          .catch(error => {
            console.error(error);
            // Handle error if needed
          });
        });
      });
    </script>

    <div class="dropDownMenu">
      <li><a href="../index.php">Home</a></li>
      <li><a href="about.php">About Us</a></li>
      <li><a href="contact.php">Contact Us</a></li>
      <button class="getStarted">Get Started</button>
    </div>
  </header>

  <!-- LOGIN & SIGN UP POP-UP WINDOWS -->
  <div class="wrapper">
    <span class="icon-close">
      <i class="fa-solid fa-xmark"></i>
    </span>

    <!-- LOGIN -->
    <div class="form-box login">
      <h2>Login</h2>
      <form id="loginForm">
        <div class="input-box">
          <span class="icon"><i class="fa-sharp fa-solid fa-envelope"></i></span>
          <input type="email" name="email_L" />
          <label>Email</label>
        </div>
        <div class="input-box">
          <span class="icon"><i class="fa-sharp fa-solid fa-key"></i></span>
          <input type="password" name="password_L" />
          <label>Password</label>
        </div>
        <input type="hidden" name="action" value="loginAction">
        <div class="remember-forgot">
          <a id="forgotBtn">Forgot Password?</a>
        </div>
        <button type="submit" class="btn" id="loginBtn">Login</button>
        <div class="login-register">
          <p>
            Don't have an Account?
            <a href="#" class="register-link"> Register</a>
          </p>
        </div>
      </form>
    </div>

    <!-- SIGN UP -->
    <div class="form-box register">
      <h2>Sign Up</h2>
      <form id="signUpForm">
        <div class="input-box">
          <span class="icon"><i class="fa-solid fa-user"></i></span>
          <input type="text" name="username_R" /> <!-- Username Register -->
          <label>Username</label>
        </div>
        <div class="input-box">
          <span class="icon"><i class="fa-sharp fa-solid fa-envelope"></i></span>
          <input type="email" name="email_R" /> <!-- Email Register -->
          <label>Email</label>
        </div>
        <div class="input-box">
          <span class="icon"><i class="fa-sharp fa-solid fa-key"></i></span>
          <input type="password" name="password_R" /> <!-- Password Register -->
          <label>Password</label>
        </div>
        <input type="hidden" name="action" value="signUpAction">
        <div class="remember-forgot">
          <label><input type="checkbox" />I agree to the terms & conditions</label>
        </div>
        <button type="submit" class="btn" id="submitBtn">Register</button>
        <div class="login-register">
          <p>
            Already have an account?
            <a href="#" class="login-link"> Login</a>
          </p>
        </div>
      </form>
    </div>
  </div>


  <div id="phpResponse" style="margin-top: 175px; transition: none;">
    <span class="icon-close">
      <i class="fa-solid fa-xmark"></i>
    </span>
  </div>

  <section class="about">
    <div class="main">
      <div class="aboutImageContainer">
        <img src="Images/photo-1563841930606-67e2bce48b78.avif" class="aboutImage" id="aboutImage" />
      </div>
      <div class="about-text">
        <h1>About us</h1>
        <h3>Ticket<span> Bridger</span></h3>
        <p>
          Welcome to Ticket Bridger – where your ticketing experience reaches new heights!

          At Ticket Bridger, we're passionate about connecting you with the events you love. Whether it's concerts, sports games, or theater shows, we've got you covered. Our user-friendly platform allows you to effortlessly search, view, buy, and sell tickets, all in one place.

          With Ticket Bridger, you're not just purchasing tickets – you're joining a community of fellow fans who share your enthusiasm for live entertainment. Our extensive event listings ensure there's something for everyone, from the hottest concerts to the most anticipated sports matchups.

          And if you ever need assistance, our dedicated support team is here to help. We're committed to providing you with a seamless and enjoyable ticket-buying experience from start to finish.

          Join us at Ticket Bridger and let's make memories together!


        </p>
        <!--May a button hear that leeds to contact us-->
      </div>
    </div>
  </section>

  <div class="team-section">
    <div class="team-container">
      <div class="row">
        <div class="title">
          <h1>our team</h1>
          <p>
            Meet our dedicated team committed to enhancing your ticket-buying experience and ensuring your satisfaction every step of the way.
          </p>
        </div>
      </div>
      <div class="team-card">
        <div class="card">
          <div class="image-section">
            <img src="Images/Kostas.png" />
          </div>
          <div class="content">
            <h3>Kostas</h3>
            <h4>Database Designer</h4>
            <p>
              Passionate problem solver dedicated to optimizing database performance and ensuring data integrity.
            </p>
          </div>
        </div>
        <div class="card">
          <div class="image-section">
            <img src="Images/GrigorisPicture.jpg" />
          </div>
          <div class="content">
            <h3>Grigoris</h3>
            <h4>Back-end Developer</h4>
            <p>
              Expert engineer focused on building resilient and efficient backend systems to power our platform.
            </p>
          </div>
        </div>
        <div class="card">
          <div class="image-section">
            <img src="Images/Giorgos.png" />
          </div>
          <div class="content">
            <h3>George</h3>
            <h4>Web Developer/Designer</h4>
            <p>
              Innovative designer committed to crafting intuitive user interfaces that elevate the user experience.
            </p>
          </div>
        </div>
        <div class="card">
          <div class="image-section">
            <img src="Images/Fanis.png" />
          </div>
          <div class="content">
            <h3>Fanis</h3>
            <h4>Web Developer/Designer</h4>
            <p>
              Driven developer consistently striving for excellence and pushing boundaries to deliver top-notch solutions.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- FOOTER -->
  <div class="FOOTER">
    <div class="footercontainer">
      <div class="row">
        <div class="footer-col">
          <h4>Company</h4>
          <ul>
            <li><a href="about.php">About us</a></li>
            <li><a href="contact.php">Contact us</a></li>
          </ul>
        </div>

        <div class="footer-col">
          <h4>Help</h4>
          <ul>
            <li><a href="#">Terms of use</a></li>
            <li><a href="#">Refund Policy</a></li>
            <li><a href="#">FAQ</a></li>
          </ul>
        </div>

        <div class="footer-col">
          <h4>Find us on social media</h4>
          <div class="social-links">
            <a href="https://www.facebook.com/mediterraneancollege/">
              <i class="fab fa-facebook-f"></i></a>
            <a href="https://www.instagram.com/mediterranean_college?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==">
              <i class="fab fa-instagram"></i></a>
          </div>
        </div>

        <div class="footer-col">
          <h4>Copyright© Ticket Bridger</h4>
        </div>
      </div>
    </div>
  </div>

  <script src="home.js"></script>
  <script src="aboutImages.js"></script>
  <script src="json_handler.js"></script>
</body>

</html>
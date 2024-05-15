<?php
session_start();

if (!isset($_SESSION['loggedIn'])) {
  $_SESSION['loggedIn'] = 'nah';
}

include 'PHPtoJS.php';

if ($_SESSION['loggedIn'] == 'ye') {
  addClassesIcons();
}

// Database connection
$servername = "localhost";
$username = "fanis";
$password = "12345";
$dbname = "ticketbridger";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch user data
if (isset($_SESSION['username'])) { // Check if username is set in session
  $username = $_SESSION['username']; // Retrieve username from session
  $sql = "SELECT username, email FROM Users WHERE username = '$username'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $username = $row["username"];
    $email = $row["email"];
  } else {
    echo "0 results";
  }
} else {
  echo "Username not provided!";
}

$conn->close();
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

  <link rel="stylesheet" href="contact.css" />

  <link rel="stylesheet" type="text/css" href="footer.css" />

  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="stylesheet" href="home.css" />
  <link rel="stylesheet" href="editProfile.css" />


  <title>Ticket Bridger</title>
</head>

<body class="ContactPage">
  <header>
    <div class="navBar">
      <div class="logo">
        <img src="Images/LogoImage.png" alt="logoImage" onclick="window.location.href='./home.php';" />
      </div>
      <ul class="links">
        <li><a href="home.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php">Contact Us</a></li>
      </ul>
      <div class="actionButtons">
        <button class="getStarted close">Get Started</button>
        <i class="usericon active fa-solid fa-user"></i>
        <div class="toggleButton">
          <i class="fa-solid fa-bars"> </i>
        </div>
      </div>
    </div>

    <div class="userDropMenu Logout" style="right: 3rem;">
      <li><a href="#" id="Logout">Logout</a></li>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
      $(document).ready(function() {
        $('#Logout').on('click', function() {
          $.ajax({
            url: 'tempLogout.php', // Path to your PHP script to destroy the session
            method: 'POST',
            success: function(response) {
              // Redirect to index.php after session is destroyed
              window.location.href = 'home.php';
            },
            error: function(xhr, status, error) {
              console.error(xhr.responseText);
              // Handle error if needed
            }
          });
        });
      });
    </script>

    <div class="dropDownMenu">
      <li><a href="home.php">Home</a></li>
      <li><a href="about.php">About Us</a></li>
      <li><a href="contact.php">Contact Us</a></li>
      <button class="getStarted">Get Started</button>
    </div>
  </header>

  <div class="edit-profile-form" style="margin-top: 200px;">
    <h2>Edit Profile</h2>
    <form action="updateProf.php" method="POST">
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo $username; ?>" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
      </div>
      <button type="submit">Update Profile</button>
    </form>
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


</body>

</html>
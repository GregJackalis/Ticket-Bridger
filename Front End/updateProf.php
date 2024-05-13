<?php
session_start();

// Function to validate username format
function validateUsernameFormat($username)
{
  // Check if username matches the pattern
  if (!preg_match("/^[a-zA-Z_' -]*$/", $username)) {
    return false; // Invalid username format
  }
  return true; // Valid username format
}

// Function to check if the email already exists in the database
function checkingEmail($email_value, $currentUsername)
{
  if (empty($email_value)) {
    return false;
  } elseif (!filter_var($email_value, FILTER_VALIDATE_EMAIL)) {
    return false;
  } else {
    // Database connection
    $servername = "localhost";
    $username = "fanis";
    $password = "12345";
    $dbname = "ticketbridger";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to check if email exists for the current user
    $sql = "SELECT * FROM Users WHERE email = ? AND username != ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email_value, $currentUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if email exists in the database for a different user
    if ($result->num_rows > 0) {
      return false; // Email already exists for a different user
    } else {
      return true; // Email doesn't exist for any other user
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
  }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Check if user is logged in
  if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == 'ye') {
    // Check if username and email are provided
    if (isset($_POST['username']) && isset($_POST['email'])) {
      // Sanitize user input
      $newUsername = htmlspecialchars($_POST['username']);
      $newEmail = htmlspecialchars($_POST['email']);

      // Validate username format
      if (!validateUsernameFormat($newUsername)) {
        echo "<script>alert('Invalid username format.');</script>";
        echo "<script>window.history.back();</script>";
        exit(); // Stop further execution
      }

      // Check if the new email already exists
      if (!checkingEmail($newEmail, $_SESSION['username'])) {
        echo "<script>alert('The provided email already exists. Please choose a different one.');</script>";
        echo "<script>window.history.back();</script>";
        exit(); // Stop further execution
      }

      // Database connection
      $servername = "localhost";
      $db_username = "fanis";
      $db_password = "12345";
      $dbname = "ticketbridger";

      $conn = new mysqli($servername, $db_username, $db_password, $dbname);
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      // Prepare SQL statement to update user's profile
      $sql = "UPDATE Users SET username = ?, email = ? WHERE username = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("sss", $newUsername, $newEmail, $_SESSION['username']);

      // Execute the statement
      if ($stmt->execute()) {
        // Update session username if username is updated
        $_SESSION['username'] = $newUsername;
        echo "<script>alert('Profile updated successfully.');</script>";
        echo "<script>window.open('home.php', '_self');</script>";
      } else {
        echo "Error updating profile: " . $conn->error;
      }

      // Close statement and database connection
      $stmt->close();
      $conn->close();
    } else {
      echo "Username or email not provided.";
    }
  } else {
    echo "You are not logged in.";
  }
} else {
  echo "Invalid request.";
}

<?php
session_start();

$name = $email = $website = $nameErr = $emailErr = $websiteErr = $gender = $genderErr = '';

if (!isset($_SESSION['loggedIn'])) {
  $_SESSION['loggedIn'] = 'nah';
}

include 'PHPtoJS.php';

if ($_SESSION['loggedIn'] == 'ye') {
  addClassesIcons();
}
?>

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/* Database credentials. */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'kostas');
define('DB_PASSWORD', '12345');
define('DB_NAME', 'ticketbridger');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

function setup_data($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$title = $date = $city = $original_price = $selling_price = $number_of_ticket = $kind = "";
$titleErr = $dateErr = $cityErr = $original_priceErr = $selling_priceErr = $number_of_ticketErr = $kindErr = $fileErr = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate input   
    if(empty(trim($_POST["title"]))){
        $titleErr = "*";
    } else {
        $title = setup_data($_POST["title"]);
    }

    if(empty(trim($_POST["date"]))){
        $dateErr = "*";
    }else {
        $date = setup_data($_POST["date"]);
    }

    if(empty(trim($_POST["city"]))){
      $cityErr = "*";
    }else {
      $city = setup_data($_POST["city"]);
    }

    if(empty(trim($_POST["original_price"]))){
      $original_priceErr = "*";
    }else {
      $original_price = setup_data($_POST["original_price"]);
    }

    if(empty(trim($_POST["selling_price"]))){
      $selling_priceErr = "*";
    }else {
      $selling_price = setup_data($_POST["selling_price"]);
    }

    if(empty(trim($_POST["number_of_ticket"]))){
      $number_of_ticketErr = "*";
    }else {
      $number_of_ticket = setup_data($_POST["number_of_ticket"]);
    }

    if(empty(trim($_POST["kind"]))){
      $kindErr = "*";
    }else {
      $kind = setup_data($_POST["kind"]);
    }

    if(empty($_FILES["file"]["name"])){
      $fileErr = "*";
    } else {
         // Process file upload
        $target_dir = 'tickets/';
        $fileName = basename($_FILES["file"]["name"]);
        $targetPath = $target_dir . $fileName;

        // Check if the directory exists and is writable
        if (!is_dir($target_dir)) {
            $fileErr = "Error: Destination directory does not exist or is not writable.";
        } else {
            // Attempt to move the uploaded file
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetPath)) {
                // File uploaded successfully
            } else {
                $fileErr = "Failed to move uploaded file.";
            }
        }
}

    // Check for errors before inserting into database
    if(empty($titleErr) && empty($dateErr) && empty($cityErr) && empty($original_priceErr)
        && empty($selling_priceErr) && empty($number_of_ticketErrr) && empty($kindErr) && empty($fileErr)){

        // Prepare an insert statement
        $sql = "INSERT INTO ticket1 (title, date, city, original_price, selling_price, number_ticket, kind, file_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssiiiss", $param_title, $param_date, $param_city, $param_original_price, $param_selling_price, $param_number_of_ticket, $param_kind, $param_file_path);

            // Set parameters
            $param_title = $title;
            $param_date = $date;
            $param_city = $city;
            $param_original_price = $original_price;
            $param_selling_price = $selling_price;
            $param_number_of_ticket = $number_of_ticket;
            $param_kind = $kind;
            // $param_file_path = $uploads_dir.$pname;
            $param_file_path = $targetPath;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store form data is session variables
                // $_SESSION['title'] = $title;
                // $_SESSION['date'] = $date;
                // $_SESSION['city'] = $city;
                // $_SESSION['original_price'] = $original_price;
                // $_SESSION['selling_price'] = $selling_price;
                // $_SESSION['number_of_ticket'] = $number_of_ticket;
                // $_SESSION['kind'] = $kind;
                // $_SESSION['file_path'] = $uploads_dir . '/' . $pname;

                // Redirect to sell page
                header("location: sell.php?success=true");
                exit();
            } else {
              header("location: sell.php?success=false");
              exit();
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
      integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="about.css" />
    <link rel="stylesheet" type="text/css" href="footer.css" />
    <link rel="stylesheet" href="ourTeam.css" />
    <link rel="stylesheet" href="./sell.css">
    <link
      rel="stylesheet"
      type="text/css"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    />
    <link rel="stylesheet" href="home.css" />
    <title>Selling</title>
</head>
<body class="SellingPage">
    <header>
        <div class="navBar">
        <div class="logo">
            <img src="Images/LogoImage.png" alt="logoImage" onclick="window.location.href='home.php';"/>
        </div>
        <ul class="links">
            <li><a href="home.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="services.php">Services</a></li>
            <li><a href="contact.php">Contact Us</a></li>
        </ul>
        <div class="actionButtons">
            <button class="getStarted close">Get Started</button>
            <i class="carticon active fa-solid fa-cart-shopping"></i>
            <i class="usericon active fa-solid fa-user"></i>
            <div class="toggleButton">
                <i class="fa-solid fa-bars"> </i>
            </div>
            </div> 
        </div>
    
        <!--dropdown menu-->
        <div class="dropDownMenu">
            <li><a href="home.html">Home</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="services.html">Services</a></li>
            <li><a href="contact.html">Contact Us</a></li>
            <button class="getStarted">Get Started</button>
        </div>
    </header>

<h1>Upload Your Tickets Here</h1>
<div class="description">
    <p>With our trusted system, you can rest assured that your transactions
    are protected.</p>
</div>

<div class="line"></div>


<div class="Image">
    <div class="container"> 
         <div class="box">
            <div class="flip-card">
                <div class="flip-card-inner">
                  <div class="flip-card-front">
                    <img src="./Images/young-beautiful-woman-blue-t-shirt-holding-air-tickets-looking-camera-smiling-cheerfully-standing-pink-background.jpg" alt="ticket woman" style="width:200px;height:200px; border-radius: 25%;">
                  </div>
                  <div class="flip-card-back">
                    <img src="./Images/young-beautiful-woman-blue-t-shirt-looking-camera-smiling-showing-open-palms-standing-pink.jpg" alt="" style="width:200px;height:200px; border-radius: 25%;">
                  </div>
                </div>
              </div>
        </div> 
     </div>
</div>
<div class="upload">
    <img src="./Images/rm373batch2-28.jpg" alt="upload_icon">
</div>

<div class="UploadForm">
  <form method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
    <div class="form-column">
      <input type="text" name="title" placeholder="Title" value="<?php echo isset($_SESSION['title']) ? $_SESSION['title'] : ''; ?>">
      <span class="error"><?php echo $titleErr;?></span>
      <br><br>
      Date & Time: <input type="datetime-local" name="date" value="<?php echo isset($_SESSION['date']) ? $_SESSION['date'] : ''; ?>" min="<?php echo date('Y-m-d\TH:i'); ?>">
      <span class="error"><?php echo $dateErr;?></span>
      <br><br>
      City: <input type="text" name="city" value="<?php echo isset($_SESSION['city']) ? $_SESSION['city'] : ''; ?>" >
      <span class="error"><?php echo $cityErr;?></span>
      <br><br>
      Original Ticket Price: <input id="ticketsInput1" type="number" name="original_price" value="<?php echo isset($_SESSION['original_price']) ? $_SESSION['original_price'] : ''; ?>" min="0" oninput="validateNumber1()">
      <span class="coin">&euro;</span>
      <span id="ticketsError1" class="error"><?php echo $original_priceErr;?></span>
      <br><br>
      Selling Price: <input id="ticketsInput2" type="number" name="selling_price" value="<?php echo isset($_SESSION['selling_price']) ? $_SESSION['selling_price'] : ''; ?>" step="any" min="0" oninput="validateNumber2()">
      <span class="coin">&euro;</span>
      <span id="ticketsError2" class="error"><?php echo $selling_priceErr;?></span>
      <br><br>
      Number of Tickets: <input id="ticketsInput" type="number" name="number_of_ticket" value="<?php echo isset($_SESSION['number_of_ticket']) ? $_SESSION['number_of_ticket'] : ''; ?>" oninput="validateNumberOfTickets()">
      <span id="ticketsError" class="error"><?php echo $number_of_ticketErr?></span>
      <br><br>
    </div>
    <div class="form-column">
    <img src="./Images/scan_me_qr_code.jpg" alt="barcode">
      <br><br><br>
      <br><br>
      Kind:
      <br><br>
      <div class="kinds">
      <input type="radio" name="kind" <?php if (isset($_SESSION['kind']) && $_SESSION['kind'] == "music") echo "checked"; ?> value="Music">Music
      <input type="radio" name="kind" <?php if (isset($_SESSION['kind']) && $_SESSION['kind'] == "sport") echo "checked"; ?> value="Sport">Sport
      <input type="radio" name="kind" <?php if (isset($_SESSION['kind']) && $_SESSION['kind'] == "cinema") echo "checked"; ?> value="Cinema">Cinema  
      <input type="radio" name="kind" <?php if (isset($_SESSION['kind']) && $_SESSION['kind'] == "theater") echo "checked"; ?> value="Theater">Theater  
      <span class="error"><?php echo $kindErr ?></span>
      </div>
      <br>
      Upload Ticket: <input type="File" name="file" value="<?php echo isset($_SESSION['path_file']) ? $_SESSION['path_file'] : '';?>" accept=".pdf">
      <span class="error"><?php echo $fileErr?></span>
      <br><br>
      <input type="submit" name="submit" value="Upload">
    </div>  
  </form>
</div>
    <script src="./sell.js"></script>
    <script>window.onload = function() {
        displayMessage();
      };
    </script>
</body>
</html>


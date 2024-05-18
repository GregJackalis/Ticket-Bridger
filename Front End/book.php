<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

// Database connection
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'smth');
define('DB_PASSWORD', 'smth!');
define('DB_NAME', 'smth');

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check the connection
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

function setup_data($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$name = $lastName = $email = "";
$name_err = $lastName_err = $email_err = "";
$ticketID = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["name"]))) {
        $name_err = "*";
    } else {
        $name = setup_data($_POST["name"]);
    }

    if (empty(trim($_POST["lastname"]))) {
        $lastName_err = "*";
    } else {
        $lastName = setup_data($_POST["lastname"]);
    }

    if (empty(trim($_POST["email"]))) {
        $email_err = "*";
    } else {
        $email = setup_data($_POST["email"]);
    }

    // Get ticketID from POST data
    if (!empty($_POST['ticketID'])) {
        $ticketID = $_POST['ticketID'];
    }

    // If there are no errors and ticketID is set, proceed to send the email
    if (empty($name_err) && empty($lastName_err) && empty($email_err) && !empty($ticketID)) {
        // Fetch ticket information from the database
        $query = "SELECT * FROM ticket1 WHERE ticketID = $ticketID";
        $result = mysqli_query($link, $query);
        $ticket = mysqli_fetch_assoc($result);

        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        // Enable exceptions
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ticketbridger@gmail.com';
        $mail->Password = 'atyq jjic vayh gxvx';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Sender and recipient
        $mail->setFrom('ticketbridger@gmail.com', 'Ticket Bridger');
        $mail->addAddress($email, $lastName . ' ' . $name);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Your Ticket Information';
        $mail->Body = '
        <html>
        <head>
        <title>Your Ticket Information</title>
        </head>
        <body>
            <h1>Ticket Details</h1>
            <p>Event Name: ' . $ticket['title'] . '</p>
            <p>Event Date: ' . $ticket['date'] . '</p>
            <p>Event City: ' . $ticket['city'] . '</p>
            <p>Selling Price: ' . $ticket['selling_price'] . '</p> </br></br>
            <p>Thank you for your preference</p>
        </body>
        </html>';

        // Add PDF attachment
        $pdfFilePath = $ticket['file_path'];
        $mail->addAttachment($pdfFilePath);

        try {
            // Send the email
            $mail->send();
            echo '<script>alert("Email sent successfully!");</script>';
            echo "<script>window.open('../index.php','_self')</script>";
        } catch (Exception $e) {
            echo '<script>alert("Email could not be sent. Mailer Error: ' . $mail->ErrorInfo . '");</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="about.css" />
    <link rel="stylesheet" href="footer.css" />
    <link rel="stylesheet" href="ourTeam.css" />
    <link rel="stylesheet" href="./book.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="home.css" />

    <title>Book</title>
</head>

<body class="SellingPage">
    <header>
        <div class="navBar">
            <div class="logo">
                <img src="Images/LogoImage.png" alt="logoImage" onclick="window.location.href='../index.php';" />
            </div>
            <ul class="links">
                <li><a href="../index.php">Home</a></li>
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

        <div class="userDropMenu" style="right: 3rem;">
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

        <!--dropdown menu-->
        <div class="dropDownMenu">
            <li><a href="home.html">Home</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="contact.html">Contact Us</a></li>
            <button class="getStarted">Get Started</button>
        </div>
    </header>

    <h1>Ticket's Data</h1>

    <div class="line"></div>

    <div class="bookForm">
        <form method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

            <input type="text" name="name" placeholder="Name">
            <span class="error"><?php echo $name_err; ?></span>
            <br><br>
            <input type="text" name="lastname" placeholder="Last Name">
            <span class="error"><?php echo $lastName_err; ?></span>
            <br><br>
            <input type="text" name="email" placeholder="Email">
            <span class="error"><?php echo $email_err; ?></span>
            <br><br>

            <!-- Hidden input field for ticketID -->
            <input type="hidden" name="ticketID" value="<?php echo isset($_GET["ticketID"]) ? htmlspecialchars($_GET["ticketID"]) : ''; ?>">

            <input type="submit" name="submit" value="Submit">
        </form>
    </div>

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
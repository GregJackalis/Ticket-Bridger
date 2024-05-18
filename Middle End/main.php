<?php

// CODE FOR SESSION WITH PHP 
session_start();

if (!isset($_SESSION['loggedIn'])) {
    $_SESSION['loggedIn'] = 'nah';
}

// Enable error reporting and logging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Log errors to a file
ini_set('log_errors', 1);
ini_set('error_log', 'error.log');

include 'functions.php';
include 'get_env.php';

$response = array(
    "status" => null,
    "message" => null,
    "errors" => array(
        "email" => null,
        "username" => null,
        "password" => null,
    )
);

//  Access environment variables
$db_Data = get_env_data('db'); // sending the type of data that i want the function to return

try {
    $dbServername = $db_Data[0];
    $dbUsername = $db_Data[1];
    $dbPassword = $db_Data[2];
    $dbName = $db_Data[3];
    // $response["message"] = $dbServername . $dbUsername . $dbPassword . $dbName;
} catch (Error) {
    $response["status"] = "error";
    $response["message"] = "Failed to get env data";
};

$username = $email = $password = $action = "";
$usernameCheck = $emailCheck = $passwordCheck = false;

$db_connection = connect_to_database($dbServername, $dbUsername, $dbPassword, $dbName);
// $response["message"] = connect_to_database($dbServername, $dbUsername, $dbPassword, $dbName);

if ($db_connection == false) {
    $response["status"] = "error";
    $response["message"] = "Failed to connect to database!";
} else {
    $response["status"] = "db success";
    $response["message"] = "Connected to database!";
}

$data = json_decode(file_get_contents('php://input'), true);
// header('Content-Type: application/json');
// echo json_encode($data['action']);
// exit;


if ($_SERVER["REQUEST_METHOD"] == "POST" && $db_connection != false) {

    $action = $data['action'];

    if ($action == "signUpAction") {
        // in case the request method is post then it means that a user is trying to sign up most
        //  defintely (for now at least...)
        $username = setup_data($data["username_R"]);
        $email = setup_data($data["email_R"]);
        $password = $data["password_R"]; // the password's data doesn't need to be in the setup_data because it might affect the
        // actual value of the it.

        $emailCheck = checkingEmail($email);
        $usernameCheck = checkingUsername($username);
        $passwordCheck = checkingPassword($password);

        if ($emailCheck && $usernameCheck && $passwordCheck) {
            //  1st) encrypt the password with one or more different encryption algorithms (with the usage of secret keys 
            //       stored in a .env file), and then put it in the variable that the username and password are already in.

            $insertion_response = insert_into_table($username, $email, $password, "users", $db_connection);

            $response = array(
                "status" => "register success",
                "message" => "Credentials have been Validated"
            );
        } else {
            $response["status"] = "register error";
            $response["message"] = "Validation failed";
            if (!$emailCheck) {
                $response["errors"]["email"] = "Invalid Email Given";
            }

            if (!$usernameCheck) {
                $response["errors"]["username"] = "Invalid Username Given";
            }

            if (!$passwordCheck) {
                $response["errors"]["password"] = "Invalid Password Given";
            }
        }
    } elseif ($action == "loginAction") {
        $email = setup_data($data["email_L"]);
        $password = setup_data($data["password_L"]);

        $sqlResponse = get_from_table($email, $password, "users", $db_connection);

        if ($sqlResponse == "cred") {
            $response["status"] = "missing cred error";
            $response["message"] = "Missing Credentials!";
            $_SESSION['loggedIn'] = 'nah';
        } else if ($sqlResponse == "rec") {
            $response["status"] = "no records";
            $response["message"] = "No records found!";
            $_SESSION['loggedIn'] = 'nah';
        } else if ($sqlResponse == "inv") {
            $response["status"] = "login error";
            $response["message"] = "Invalid Credentials!";
            $_SESSION['loggedIn'] = 'nah';
        } else { // THIS IS THE SUCCESS CASE IN THE LOGIN PHASE
            $response["status"] = "login success";
            $response["message"] = $sqlResponse;
            $_SESSION['loggedIn'] = 'ye';
            $_SESSION['username'] = $sqlResponse;
        }
    } else if ($action == "changePass") {

        $infoArr = [ setup_data($data["userEmail"]), setup_data($data["oldPassword"]), setup_data($data["newPassword"]), setup_data($data["reEnterPassword"]) ];

        $hasChanged = changePassword($infoArr, $db_connection);

        if ($hasChanged === true) {
            $response["status"] = "success";
            $response["message"] = "passChanged";
        } else {
            $response["status"] = "failed";
            $response["message"] = $hasChanged;
        }


    }
}

header('Content-Type: application/json');
echo json_encode($response);

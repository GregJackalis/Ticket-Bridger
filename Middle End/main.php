<?php
    // error_reporting(0);
    ini_set('display_errors', 1);

    include 'functions.php';

    $username = $email = $password = "";
    $usernameCheck = $emailCheck = $passwordCheck = false;

    $response = array(
        "status" => "error",
        "message" => "Validation failed",
        "errors" => array(
            "email" => null,
            "username" => null,
            "password" => null,
        )
    );

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // in case the request method is post then it means that a user is trying to sign up most
        //  defintely (for now at least...)
        $username = setup_data($_POST["username_R"]);
        $email = setup_data($_POST["email_R"]);
        $password = $_POST["password_R"]; // the password's data doesn't need to be in the setup_data because it might affect the
                                          // actual value of the it.

        $emailCheck = checkingEmail($email);
        $usernameCheck = checkingUsername($username);
        $passwordCheck = checkingPassword($password);

        if ($emailCheck && $usernameCheck && $passwordCheck) {
            //  1st) encrypt the password with one or more different encryption algorithms (with the usage of secret keys 
            //       stored in a .env file), and then put it in the variable that the username and password are already in.

            //  2nd) insert email, username, and password to a variable that will be 
            //  inserted to the database (if all the checks for each field are true)
            //  need to use the "INSERT..." query to insert all email, username, and password

            $response = array(
                "status" => "success",
                "message" => "Credentials have been Validated",
            );

        } else {
            if (!$emailCheck) {
                $response['errors']['email'] = 'Invalid Email Given';
            }

            if (!$usernameCheck) {
                $response['errors']['username'] = 'Invalid Username Given';
            }

            if (!$passwordCheck) {
                $response['errors']['password'] = 'Invalid Password Given';
            }
        }

        // header('Content-Type: application/json');

        // file_put_contents('main_php_debug.txt', json_encode($response));

        // Output the JSON response containing information about which credential was invalid
        // echo json_encode($response);

        $html_response = "<h2>Errors while Signing up!</h2><br>";
        $errors = $response['errors'];

        foreach ($errors as $error) {
            if ($error !== null) {
                $html_response .= "<p>$error</p><br>";
            }
        }

        echo $html_response;


    }
?>
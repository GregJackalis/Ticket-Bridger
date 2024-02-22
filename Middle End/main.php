<?php
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

        if (checkingEmail($email)) {
            //  insert email to a variable that will be inserted to the database (if all the checks for each field are true)
            $emailCheck = true;
        } else {
            $response['errors']['email'] = 'Invalid Email Given';
        }

        if (checkingUsername($username)) {
            // insert username to a variable just like the email..
            $usernameCheck = true;
        } else {
            $response['errors']['username'] = 'Invalid Username Given';
        }

        if (checkingPassword($password)) {
            // encrypt the password with one or more different encryption algorithms (with the usage of secret keys stored in a 
            // .env file), and then put it in the variable that the username and password are already in.
            $passwordCheck = true;
        } else {
            $response['errors']['password'] = 'Invalid Password Given';
        }

        if ($emailCheck && $usernameCheck && $passwordCheck) {
            // if all of them are true then it means that they passed the check for valid information give, and the info is ready
            // to be inserted to the databasd

            // need to insert the "INSERT..." query to insert all email, username, and password
            
        } else {
            // in case one of them is false, then it means that there was a problem with the data given (it was not valid)

            // Set the appropriate Content-Type header for JSON
            header('Content-Type: application/json');

            // Output the JSON response containing information about which credential was invalid
            echo json_encode($response);
        }
    }
?>
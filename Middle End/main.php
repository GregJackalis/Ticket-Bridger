<?php
    // error_reporting(0);
    ini_set('display_errors', 1);

    include 'functions.php';
    include 'users.php';

    $username = $email = $password = $action = "";
    $usernameCheck = $emailCheck = $passwordCheck = false;

    $response = array(
        "status" => "error",
        "message" => null,
        "errors" => array(
            "email" => null,
            "username" => null,
            "password" => null,
        )
    );

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $action = $_POST["action"];
        
        if ($action == "signUpAction") {
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
                $users[] = array(
                    'email' => $email,
                    'username' => $username,
                    'password' => $password
                );
                
                $response = array(
                    "status" => "success",
                    "message" => "Credentials have been Validated",
                );

            } else {
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
            $email = setup_data($_POST["email_L"]);
            $password = setup_data($_POST["password_L"]);
            if (empty($users)) {
                $response["message"] = "There are no users registered yet!";
            } else {
                foreach ($users as $user) {
                    if ($user['email'] == $email && $user['password'] == $password) {
                        $response["status"] = "success";
                        $response["message"] = "User has Successfully Logged In!";
                        break;
                    }
                }
                
                // if status in the json response array/object has remained "error", then the credentials given are not correct
                if ($response["status"] == "error") {
                    $response["message"] = "User has given wrong credentials!";
                }
            }
            // $response["message"] = $users;
        }
        
        header('Content-Type: application/json');
        echo json_encode($response);

    }
?>
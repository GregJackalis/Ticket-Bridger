<?php
    function setup_data($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function checkingEmail($email_value) {
        if (empty($email_value)) {
            return false;
        } elseif ((!filter_var($email_value, FILTER_VALIDATE_EMAIL))) {
            return false;
        } else {
            return true;
        }
        // need to also add the case where the email is checked for whether it already exists in the database
    }

    function checkingUsername($username_value) {
        if (empty($username_value)) {
            return false;
        } elseif (!preg_match("/^[a-zA-Z-' ]*$/",$username_value)) {
            return false;
        } else {
            return true;
        }
        // just like the email checking function, in the future i will need to add an if statement
        // for the case the username is already used by another user (this will be done with query
        // of course)
    }

    function checkingPassword($password_value) {
        $uppercase = preg_match('@[A-Z]@', $password_value);
        $lowercase = preg_match('@[a-z]@', $password_value);
        $number = preg_match('@[0-9]@', $password_value);
        $specialChars = preg_match('@[^\w]@', $password_value);

        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password_value) < 8) {
            // 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
            return false;
        } else {
            return true;
        }
    }

    function connect_to_database($server, $user, $pass, $db_name) {
        $conn = new mysqli($server, $user, $pass, $db_name);
            // Check connection
            if ($conn->connect_error) {
                return false;
            } else {
                return $conn;
            }
    }

    function insert_into_table($username_R, $email_R, $password_R, $table_name, $db_conn) {
        $stmt = $db_conn->prepare("INSERT INTO $table_name (username, email, password) VALUES (?, ?, ?)"); 
    
        $stmt->bind_param("sss", $user, $email, $pass);
    
        $user = $username_R;
        $email = $email_R;
        $pass = $password_R;
        $stmt->execute();
        //     return true; // Return true if insertion is successful
        // } catch (\PDOException $e) {
        //     // Log the error or handle it appropriately
        //     error_log("Error inserting data: " . $e->getMessage());
        //     return false; // Return false on failure
        // }
    }
    
?>
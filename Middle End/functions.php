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
            echo 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
            return false;
        } else {
            echo 'Strong password.';
            return true;
        }
    }
?>
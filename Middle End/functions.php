<?php
function setup_data($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function checkingEmail($email_value)
{
    if (empty($email_value)) {
        return false;
    } elseif ((!filter_var($email_value, FILTER_VALIDATE_EMAIL))) {
        return false;
    } else {
        // Database connection
        $servername = "localhost";
        $username = "smth";
        $password = "smth!";
        $dbname = "smth";

        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare SQL statement to check if email exists
        $sql = "SELECT * FROM Users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email_value);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if email exists in the database
        if ($result->num_rows > 0) {
            return false; // Email already exists
        } else {
            return true; // Email doesn't exist
        }

        // Close statement and database connection
        $stmt->close();
        $conn->close();
    }
}

function checkingUsername($username_value)
{
    if (empty($username_value)) {
        return false;
    } elseif (!preg_match("/^[a-zA-Z_' -]*$/", $username_value)) {
        return false;
    } else {
        return true;
    }
    // just like the email checking function, in the future i will need to add an if statement
    // for the case the username is already used by another user (this will be done with query
    // of course)
}

function checkingPassword($password_value)
{
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

function connect_to_database($server, $user, $pass, $db_name)
{
    $conn = mysqli_connect($server, $user, $pass, $db_name);
    // Check connection
    if ($conn->connect_error) {
        return false;
    } else {
        return $conn;
    }
}

function insert_into_table($username_R, $email_R, $password_R, $table_name, $db_conn)
{
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

function get_from_table($email_L, $password_L, $table_name, $db_conn)
{
    if (empty($email_L) || empty($password_L)) {
        return 'cred';
    } else {
        // Use prepared statement to prevent SQL injection
        $sql = "SELECT username, password FROM $table_name WHERE email = ?";
        $stmt = $db_conn->prepare($sql);
        $stmt->bind_param("s", $email_L);
        $stmt->execute();
        $result = $stmt->get_result();

        $number_of_rows = $result->num_rows;

        if ($number_of_rows == 0) {
            return "rec";
        } else {
            $row = $result->fetch_assoc();
            if ($row["password"] == $password_L) {
                return $row["username"];
            } else {
                return "inv";
            }
        }
    }
}


function changePassword($userArr, $db_conn) {
    // in array ==> email, old password, new password, re-entered new password

    // 1st step: check if email exists in db
    // 2nd step: check if old password is true (after the first step is true)
    // 3rd step: check if two new passwords much with each other
    // 4th step: check if new password matches the constraints
    // 5th step: if all checks are passed, change password on db

    $sql = "SELECT username, email, password FROM users WHERE email = ?";
    $stmt = $db_conn->prepare($sql);
    $stmt->bind_param("s", $userArr[0]);
    $stmt->execute();
    $result = $stmt->get_result();

    // first step
    if ($result->num_rows > 0) {

        // assuming that only one record is found since emails are unique
        $row = $result->fetch_assoc();

        // second step
        if ($row["password"] === $userArr[1]){

            // third step
            if ($userArr[2] === $userArr[3]) {

                // fourth step
                if (checkingPassword($userArr[2])) {

                    // fifth step
                    $sql = "UPDATE users SET password = ? WHERE email = ? AND password = ?";
                    $stmt = $db_conn->prepare($sql);
                    $stmt->bind_param("sss", $userArr[2], $userArr[0], $userArr[1]);
                    $stmt->execute();

                    if ($stmt->affected_rows > 0) {
                        return true;
                    } else {
                        return "errDb";
                    }

                } else {
                    return "invPass";
                }

            } else {
                return "noMatch"; // new passwords do not match
            }
        } else {
            return "invOld"; // old password do not match with the one in DB
        }

    } else {
        return "noEmail"; // no email was found with the email given
    }
}

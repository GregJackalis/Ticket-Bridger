<?php

function get_env_data($type)
{
    // Define the path to the .env file
    $env_file_path = __DIR__ . "/../Classified/database.env";

    // Check if the .env file exists
    if (!file_exists($env_file_path)) {
        echo __DIR__;
        die('.env file not found');
    }

    // Read the .env file into an array of lines
    $lines = file($env_file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // Iterate through each line
    foreach ($lines as $line) {
        // Ignore lines starting with '#' (comments) or lines without an '=' sign
        if (strpos(trim($line), '#') === 0 || strpos(trim($line), '=') === false) {
            continue;
        }

        // Split the line into key and value
        list($key, $value) = explode('=', $line, 2);

        // Trim any whitespace from the key and value
        $key = trim($key);
        $value = trim($value);

        // Set the environment variable
        putenv("$key=$value");
    }

    if ($type == 'db') {
        // Now you can access your variables
        $server = getenv('SERVERNAME');
        $user = getenv('DB_USERNAME');
        $password = getenv('DB_PASSWORD');
        $name = getenv('DB_NAME');

        return array($server, $user, $password, $name);
    }
}

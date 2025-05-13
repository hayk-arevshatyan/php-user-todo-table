<?php

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'api_info';
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function fetchUsersFromAPI($apiUrl) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

function createUsersTable($conn) {
    $conn->query("CREATE TABLE IF NOT EXISTS `users` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(255),
        `company` VARCHAR(255),
        `username` VARCHAR(255),
        `email` VARCHAR(255),
        `address` VARCHAR(255),
        `zip` VARCHAR(20),
        `state` VARCHAR(100),
        `country` VARCHAR(100),
        `phone` VARCHAR(20),
        `photo` VARCHAR(255),
        `user_id` INT UNIQUE
    )");

    $apiUrl = 'https://fake-json-api.mock.beeceptor.com/users';
    $response_users = fetchUsersFromAPI($apiUrl);
    if (!empty($response_users)) {
        foreach ($response_users as $new_user) {
            if (!empty($new_user)) {
                extract($new_user);
                $email = strtolower($email);
                $id = $conn->real_escape_string($id);
                $conn->query("INSERT INTO `users` (`name`, `company`, `username`, `email`, `address`, `zip`, `state`, `country`, `phone`, `photo`, `user_id`) 
                            VALUES ('$name', '$company', '$username', '$email', '$address', '$zip', '$state', '$country', '$phone', '$photo', '$id')");
            }
        }
    }
}

function createTodosTable($conn) {
    $conn->query("CREATE TABLE IF NOT EXISTS `todo_list` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `title` VARCHAR(255) NOT NULL,
        `completed` VARCHAR(10) NOT NULL,
        `user_id` INT NOT NULL
    )");

    $todoUrl = 'https://dummy-json.mock.beeceptor.com/todos';
    $response_todos = fetchUsersFromAPI($todoUrl);
    if (!empty($response_todos)) {
        foreach ($response_todos as $new_user) {
            if (!empty($new_user)) {
                extract($new_user);
                $userId = $conn->real_escape_string($userId);
                $conn->query("INSERT INTO `todo_list` (`title`, `completed`, `user_id`) VALUES ('$title', '$completed', '$userId')");
            }
        }
    }
}




?>


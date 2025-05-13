<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/data_base/db.php';

// START => OOP => CRUD

class User {
    public $conn;
    public $name;
    public $company;
    public $username;
    public $email;
    public $address;
    public $zip;
    public $state;
    public $country;
    public $phone;
    public $photo;
    public $user_id;

    public function __construct($conn, $name, $company, $username, $email, $address, $zip, $state, $country, $phone, $photo, $user_id) {
        $this->conn = $conn;
        $this->name = $name;
        $this->company = $company;
        $this->username = $username;
        $this->email = $email;
        $this->address = $address;
        $this->zip = $zip;
        $this->state = $state;
        $this->country = $country;
        $this->phone = $phone;
        $this->photo = $photo;
        $this->user_id = $user_id;
    }

    // CREATE
    public function create() {
        $this->conn->query("INSERT INTO `users` (`name`, `company`, `username`, `email`, `address`, `zip`, `state`, `country`, `phone`, `photo`, `user_id`) 
                                    VALUES (
                                        '{$this->name}',
                                        '{$this->company}',
                                        '{$this->username}',
                                        '{$this->email}',
                                        '{$this->address}',
                                        '{$this->zip}',
                                        '{$this->state}',
                                        '{$this->country}',
                                        '{$this->phone}',
                                        '{$this->photo}',
                                        '{$this->user_id}'
                                    )");
    }

    // READ
    public function read() {
        return $result = $this->conn->query("SELECT * FROM `users` WHERE `user_id` = {$this->user_id}");
    }

    // UPDATE
    public function update() {
        $this->conn->query("UPDATE `users` SET 
                                    `name` = '{$this->name}',
                                    `company` = '{$this->company}',
                                    `username` = '{$this->username}',
                                    `email` = '{$this->email}',
                                    `address` = '{$this->address}',
                                    `zip` = '{$this->zip}',
                                    `state` = '{$this->state}',
                                    `country` = '{$this->country}',
                                    `phone` = '{$this->phone}',
                                    `photo` = '{$this->photo}'
                                    WHERE `user_id` = '{$this->user_id}'");
    }

    // DELETE
    public function delete() {
        $this->conn->query("DELETE FROM `users` WHERE `user_id` = {$this->user_id}");
    }
}

// CREATE NEW USERS

if(!empty($_POST) && $_POST['action'] == 'all_users'){
    // createUsersTable($conn);
    extract($_POST);
    $records_per_page = 5;
    $page = htmlspecialchars(strip_tags(trim($page)));
    $page = isset($page) && is_numeric($page) ? (int)$page : 1;
    $offset = max(0, ($page - 1) * $records_per_page);
    $all_user = $conn->query("SELECT * FROM `users` LIMIT $offset, $records_per_page");
    if($all_user->num_rows > 0){
        $all_user_data = $all_user->fetch_all(MYSQLI_ASSOC);
        $total_records_result = $conn->query("SELECT COUNT(*) AS `total` FROM `users`");
        $total_records = $total_records_result->fetch_assoc()['total'];
        $total_pages = ceil($total_records / $records_per_page);
        echo json_encode(['success' => true, 'users_info' => $all_user_data, 'total_pages' => $total_pages]);
        exit;
    }else{
        echo json_encode(['success' => false, 'error' => 'Table is empty.']);
        exit;
    }
}

// CREATE TODOS

if (!empty($_POST) && $_POST['action'] == 'all_todos') {
    extract($_POST);
    $records_per_page = 5;
    $pages = htmlspecialchars(strip_tags(trim($pages)));
    $pages = isset($pages) && is_numeric($pages) ? (int)$pages : 1;
    $offset = max(0, ($pages - 1) * $records_per_page);
    
    $select_todos = $conn->query("SELECT todo_list.id AS task_id, todo_list.title AS task_title, todo_list.completed AS completed_task, users.name AS user_name, users.photo AS user_photo
                                FROM todo_list JOIN users ON todo_list.user_id = users.user_id LIMIT $offset, $records_per_page");

    if ($select_todos->num_rows > 0) {
        $result_todos = $select_todos->fetch_all(MYSQLI_ASSOC);

        $total_records_result = $conn->query("SELECT COUNT(*) AS total
                                FROM todo_list JOIN users ON todo_list.user_id = users.user_id");
        $total_records = $total_records_result->fetch_assoc()['total'];
        $todos_total_pages = ceil($total_records / $records_per_page);
        echo json_encode(['success' => true, 'todos_info' => $result_todos, 'total_pages' => $todos_total_pages]);
        exit;
    } else {
        echo json_encode(['success' => false, 'error' => 'Todo list is empty.']);
        exit;
    }
}

// START => SEARCH

if(!empty($_POST) && $_POST['action'] == 'users_search'){
    extract($_POST);
    $text = htmlspecialchars(strip_tags(trim($text)));
    if(strlen($text) > 2 && strlen($text) < 150){
        $search = $conn->query("SELECT * FROM `users` WHERE `name` LIKE '%{$text}%'");
        if($search->num_rows > 0){
            $search = $search->fetch_all(MYSQLI_ASSOC);
            $html = '';
            foreach ($search as $user_row) {
                $html .= "
                    <tr>
                        <td><img src='" . $user_row['photo'] . "' alt='photo' style='width: 50px; height: 50px; border-radius: 5px;'></td>
                        <td title='" . $user_row['name'] . "'>" . $user_row['name'] . "</td>
                        <td title='" . $user_row['company'] . "'>" . $user_row['company'] . "</td>
                        <td title='" . $user_row['username'] . "'>" . $user_row['username'] . "</td>
                        <td title='" . $user_row['email'] . "'>" . $user_row['email'] . "</td>
                        <td title='" . $user_row['address'] . "'>" . $user_row['address'] . "</td>
                        <td title='" . $user_row['zip'] . "'>" . $user_row['zip'] . "</td>
                        <td title='" . $user_row['state'] . "'>" . $user_row['state'] . "</td>
                        <td title='" . $user_row['country'] . "'>" . $user_row['country'] . "</td>
                        <td title='" . $user_row['phone'] . "'>" . $user_row['phone'] . "</td>
                        <td data-id='" . $user_row['user_id'] . "' class='action-buttons'>
                            <button class='edit'><span>Edit</span></button>
                            <button class='delete'><span>Delete</span></button>
                        </td>
                    </tr>";
            }

            echo json_encode(['success' => true, 'html' => $html]);
            exit;
        }else{
            echo json_encode(['success' => false]);
            exit;
        }
    }
}elseif(!empty($_POST) && $_POST['action'] == 'todo_search'){
    extract($_POST);

    $text = htmlspecialchars(strip_tags(trim($text)));

    if(strlen($text) > 2 && strlen($text) < 150){
        $search = $conn->query("SELECT todo_list.id AS task_id, todo_list.title AS task_title, todo_list.completed AS completed_task, users.name AS user_name, users.photo AS user_photo
                            FROM todo_list JOIN users ON todo_list.user_id = users.user_id WHERE todo_list.title LIKE '%{$text}%'");
        if($search->num_rows > 0){
            $search = $search->fetch_all(MYSQLI_ASSOC);
            $html = '';
            foreach ($search as $user_row) {
                $html .= "
                    <tr style='".($user_row['completed_task'] ? 'background-color: #78ff7d' : '')."'>
                        <td><img src='" . $user_row['user_photo'] . "' alt='photo' style='width: 50px; height: 50px; border-radius: 5px;'></td>
                        <td title='" . $user_row['user_name'] . "'>" . $user_row['user_name'] . "</td>
                        <td title='" . $user_row['task_title'] . "'>" . $user_row['task_title'] . "</td>
                        <td data-id='" . $user_row['task_id'] . "' class='action-buttons'>
                            <button class='edit-todo'><span>Edit</span></button>
                            <button class='delete-todo'><span>Delete</span></button>
                        </td>
                    </tr>";
            }

            echo json_encode(['success' => true, 'html' => $html]);
            exit;
        }else{
            echo json_encode(['success' => false]);
            exit;
        }
    }
}

// START => DELETE USER

if(!empty($_POST) && $_POST['action'] == 'delete'){
    extract($_POST);
    $id = htmlspecialchars(strip_tags(trim($id)));
    if(!empty($id) && ctype_digit($id)) {
        $user = new User($conn, '', '', '', '', '', '', '', '', '', '', $id);
        $user->delete();
        echo json_encode(['success' => true, 'message' => 'User deleted successfully.']);
    }else{
        echo json_encode(['success' => false, 'error' => 'Invalid user ID.']);
    }
    exit;
}

// START => EDIT USER

if(!empty($_POST) && $_POST['action'] == 'edit'){
    extract($_POST);
    $id = htmlspecialchars(strip_tags(trim($id)));

    if(!empty($id) && ctype_digit($id)){
        $select_id = new User($conn, '', '', '', '', '', '', '', '', '', '', $id);
        $select_id = $select_id->read();
        
        if($select_id->num_rows > 0){
            $select_id = $select_id->fetch_assoc();
            $_SESSION['edit_user'] = $select_id;
            echo json_encode(['success' => true, 'redirect' => 'http://users-table.am/pages/edit_user.php']);
            exit;
        }else {
            echo json_encode(['success' => false, 'error' => 'User does not exist.']);
            exit;
        }
    }
}

// START => DELETE TODO

if(!empty($_POST) && $_POST['action'] == 'delete_todo'){
    extract($_POST);
    $id = htmlspecialchars(strip_tags(trim($id)));
    if(!empty($id) && ctype_digit($id)) {
        $conn->query("DELETE FROM `todo_list` WHERE `id` = '$id'");
        echo json_encode(['success' => true, 'message' => 'Task deleted successfully.']);
    }else{
        echo json_encode(['success' => false, 'error' => 'Invalid user ID.']);
    }
    exit;
}

// START => EDIT TODO

if(!empty($_POST) && $_POST['action'] == 'edit_todo'){
    extract($_POST);
    $id = htmlspecialchars(strip_tags(trim($id)));

    if(!empty($id) && ctype_digit($id)){
        $select_id = $conn->query("SELECT todo_list.id AS task_id, todo_list.title AS task_title, todo_list.completed AS completed_task, users.user_id AS user_row, users.name AS user_name, users.photo AS user_photo
                                FROM todo_list JOIN users ON todo_list.user_id = users.user_id WHERE todo_list.id = '$id'");
        if($select_id->num_rows > 0){
            $_SESSION['edit_todo'] = $select_id->fetch_assoc();
            echo json_encode(['success' => true, 'redirect' => 'http://users-table.am/pages/edit_todos.php']);
            exit;
        }else {
            echo json_encode(['success' => false, 'error' => 'Task does not exist.']);
            exit;
        }
    }
}


// START => UPDATE

if(!empty($_POST) && $_POST['action'] == 'user_update'){
    foreach ($_POST as $key => $value) {
        $_POST[$key] = htmlspecialchars(strip_tags(trim($value)));
    }

    extract($_POST);

    if (!is_numeric($id) || $id <= 0) {
        $error['id'] = "Invalid ID.";
    }
    

    if (empty($name) || strlen($name) < 3 || strlen($name) > 100) {
        $error['name'] = "Name must be between 3 and 100 characters.";
    }
    
    if (!empty($company) && strlen($company) > 150) {
        $error['company'] = "Company name must not exceed 150 characters.";
    }
    
    if (empty($username) || strlen($username) < 3 || strlen($username) > 50) {
        $error['username'] = "Username must be 3-50 characters long.";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = "Invalid email format.";
    }
    
    if (!empty($address) && strlen($address) > 200) {
        $error['address'] = "Address must not exceed 200 characters.";
    }
    
    if (empty($zip) || !preg_match('/^[\d-]{3,15}$/', $zip)) {
        $error['zip'] = "ZIP code must be between 3 and 15 digits.";
    }
    
    if (!empty($state) && strlen($state) > 50) {
        $error['state'] = "State name must not exceed 50 characters.";
    }
    
    if (!empty($country) && strlen($country) > 50) {
        $error['country'] = "Country name must not exceed 50 characters.";
    }
    
    if (empty($phone) || strlen($phone) < 9 || strlen($phone) > 35) {
        $error['phone'] = "Phone number must be between 9 and 25 digits and may include a leading '+'.";
    }

    if (!empty($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $photo = $_FILES['photo'];
        $validTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxFileSize = 2 * 1024 * 1024;

        if ($photo['size'] <= $maxFileSize) {
            if (in_array(mime_content_type($photo['tmp_name']), $validTypes)) {
                $uploadPath = '../images/' . uniqid('img_', true) . '.' . pathinfo($photo['name'], PATHINFO_EXTENSION);
                if (move_uploaded_file($photo['tmp_name'], $uploadPath)) {
                    $photo = $uploadPath;
                } else {
                    $error['photo'] = 'File upload failed.';
                }
            } else {
                $error['photo'] = 'Invalid file type.';
            }
        }else {
            $error['photo'] = 'File size exceeds the maximum limit of 2MB.';
        }
    } else {
        if (!is_numeric($id) || $id <= 0) {
            $error['id'] = "Invalid ID.";
        }else{
            $user = new User($conn, '', '', '', '', '', '', '', '', '', '', $id);
            $user = $user->read();
            if($user->num_rows > 0){
                $user = $user->fetch_assoc();
                $photo = $user['photo'];
            }
        }
    }

    if(!empty($error)){
        echo json_encode(['success' => false, 'error' => $error]);
        exit;
    }else{
        $update = new User($conn, $name, $company, $username, $email, $address, $zip, $state, $country, $phone, $photo, $id);
        $update = $update->update();
        echo json_encode(['success' => true, 'redirect' => 'http://users-table.am/pages/table.php']);
        exit;
    }
}

// START => UPDATE TODO

if(!empty($_POST) && $_POST['action'] == 'update_todo'){
    foreach ($_POST as $key => $value) {
        $_POST[$key] = htmlspecialchars(strip_tags(trim($value)));
    }

    extract($_POST);

    if(!ctype_digit($id)){
        $error['id'] = 'Invalid ID format.';
    } else {
        $select_id = $conn->query("SELECT `id` FROM `todo_list` WHERE `id` = '$id'");
        if($select_id->num_rows === 0){
            $error['id'] = 'No todo item found with this ID.';
        }
    }
    
    if(!ctype_digit($user)){
        $error['users'] = 'Invalid user ID format.';
    } else {
        $select_user = $conn->query("SELECT `user_id` FROM `users` WHERE `user_id` = '$user'");
        if($select_user->num_rows === 0){
            $error['users'] = 'No user found with this ID.';
        }
    }
    

    if($competed != 1 && $competed != 0){
        $error['completed'] = 'There is no selection like ' . $competed ;
    }else{
        $competed = ($competed == 1) ? 1 : '';
    }

    if(strlen($task) < 5 || strlen($task) > 70){
        $error['task'] = 'Maximum text length must be more then 5 and less form 70.';
    }

    if(empty($error)){
        $conn->query("UPDATE `todo_list` SET `title`='$task',`completed`='$competed',`user_id`='$user' WHERE `id` = '$id'");
        echo json_encode(['success' => true, 'message' => 'Update successful.', 'redirect' => 'http://users-table.am/pages/todos.php']);
    } else {
        echo json_encode(['success' => false, 'errors' => $error]);
    }
    exit;
}

// START => USER TODOS VIEW

if(!empty($_POST) && $_POST['action'] == 'user_todos'){
    // foreach ($_POST as $key => $value) {
    //     $_POST[$key] = htmlspecialchars(strip_tags(trim($value)));
    // }
    extract($_POST);
    if(!empty($id) && ctype_digit($id)){
        $select_user_todos = $conn->query("SELECT todo_list.id AS task_id, todo_list.title AS task_title, todo_list.completed AS completed_task, users.user_id AS user_row, users.name AS user_name, users.photo AS user_photo
                                FROM todo_list JOIN users ON todo_list.user_id = users.user_id WHERE todo_list.user_id = '$id'");
        if($select_user_todos->num_rows > 0){
            $_SESSION['user_todos'] = $select_user_todos->fetch_all(MYSQLI_ASSOC);
            echo json_encode(['success' => true, 'redirect' => 'http://users-table.am/pages/user_todos.php']);
        }else{
            echo json_encode(['success' => false, 'message' => 'This user do not have task.']);
        }
    }else {
        echo json_encode(['success' => false, 'message' => 'This user do not have task.']);
    }
    exit;
}

?>

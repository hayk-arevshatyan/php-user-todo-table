<?php
session_start();
$title = 'Edit task';
require_once $_SERVER['DOCUMENT_ROOT']."/data_base/db.php";
require_once $_SERVER['DOCUMENT_ROOT']."/pages/parts/header.php";
?>

<!-- START => TODO EDITING -->

<section class="user_box">
    <div class="etiting_form">
        <?php
            if(isset($_SESSION['edit_todo'])){
                $todo = $_SESSION['edit_todo'];
                extract($todo);
            
        ?>
        
        <!-- ALL USERS SELECT -->
        <span class="input_box">
            <label>Users</label>
            <select class="names_input input_zone">
                <option value="<?= $user_row?>" selected><?= $user_name?></option>
                <?php
                    $select_users = $conn->query("SELECT `user_id`, `name` FROM `users`");
                    if($select_users->num_rows > 0){
                        foreach ($select_users as $value) {
                ?>
                <option value="<?= $value['user_id']?>"><?= $value['name']?></option>
                <?php } 
                }?>
            </select>
        </span>
        <span class="users_error error_message"></span>
        
        <!-- FALSE OR TRUE -->
        <span class="input_box">
            <label>Completed</label>
            <select class="completed_input input_zone">
                <option value="<?= $completed_task ? 1 : 0?>" selected><?= $completed_task ? 'Is done' : 'Is not done'?></option>
                <option value="<?= $completed_task ? 0 : 1?>"><?= $completed_task ? 'Is not done' : 'Is done'?></option>
            </select>
        </span>
        <span class="completed_error error_message"></span>

        <span class="input_box">
            <label>Task title</label>
            <input type="text" value='<?= $task_title?>' class='task_input input_zone'/>
            <span class="border_bottom"></span>
        </span>
        <span class="task_error error_message"></span>

        <span class="back_and_update">
            <a href="http://users-table.am/pages/todos.php">cancel</a>
            <button data-id='<?= $task_id?>' class="edit_todo">Edit</button>
        </span>
        <?php
            }
        ?>
    </div>
</section>

<?php
require_once $_SERVER['DOCUMENT_ROOT']."/pages/parts/footer.php";
?>
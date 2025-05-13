<?php
session_start();
$title = 'Update user';
require_once $_SERVER['DOCUMENT_ROOT'].'/pages/parts/header.php';
?>

<!-- START => EDIT USER -->


<section class="user_box">
    <div class="etiting_form">
        <?php
            if(isset($_SESSION['edit_user'])){
                $user = $_SESSION['edit_user'];
                extract($user);
            
        ?>
        <span class="photo_changing">
            <img src="<?= $photo?>" alt="Photo">
            <input type="file" accept="image/*" class="photo_input">
        </span>
        <span class="photo_error error_message"></span>
        <span class="input_box">
            <label>Name</label>
            <input type="text" value='<?= $name?>' class='name_input input_zone'/>
            <span class="border_bottom"></span>
        </span>
        <span class="name_error error_message"></span>
        <span class="input_box">
            <label>Company</label>
            <input type="text" value='<?= $company?>' class="company_input input_zone">
            <span class="border_bottom"></span>
        </span>
        <span class='company_error error_message'></span>
        <span class="input_box">
            <label>Username</label>
            <input type="text" value='<?= $username?>' class="username_input input_zone">
            <span class="border_bottom"></span>
        </span>
        <span class='username_error error_message'></span>
        <span class="input_box">
            <label>Email</label>
            <input type="email" value='<?= $email?>' class='email_input input_zone'>
            <span class="border_bottom"></span>
        </span>
        <span class="email_error error_message"></span>
        <span class="input_box">
            <label>Address</label>
            <input type="text" value='<?= $address?>' class='address_input input_zone'>
            <span class="border_bottom"></span>
        </span>
        <span class="address_error error_message"></span>
        <span class="input_box">
            <label>Zip</label>
            <input type="text" value='<?= $zip?>' class='zip_input input_zone'>
            <span class="border_bottom"></span>
        </span>
        <span class="zip_error error_message"></span>
        <span class="input_box">
            <label>State</label>
            <input type="text" value='<?= $state?>' class='state_input input_zone'>
            <span class="border_bottom"></span>
        </span>
        <span class="state_error error_message"></span>
        <span class="input_box">
            <label>Country</label>
            <input type="text" value='<?= $country?>' class='country_input input_zone'>
            <span class="border_bottom"></span>
        </span>
        <span class="country_error error_message"></span>
        <span class="input_box">
            <label>Phone</label>
            <input type="text" value='<?= $phone?>' class='phone_input input_zone'>
            <span class="border_bottom"></span>
        </span>
        <span class="phone_error error_message"></span>
        <span class="back_and_update">
            <a href="http://users-table.am/pages/table.php">cancel</a>
            <button data-id='<?= $user_id?>' class="edit_user">Edit</button>
        </span>
        <?php
            }
        ?>
    </div>
</section>

<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/pages/parts/footer.php';
?>
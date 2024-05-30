<?php
require 'config/database.php';

// Get from data if submit button was clicked
if(isset($_POST['submit'])) {
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);
    $avatar = $_FILES['avatar'];
    
    // validate the data
    if(!$firstname) {
        $_SESSION['add_user'] = "Vui lòng nhập tên của bạn";
    } elseif(!$lastname) {
        $_SESSION['add_user'] = "Vui lòng nhập họ của bạn";
    } elseif(!$username) {
        $_SESSION['add_user'] = "Vui lòng nhập tên người dùng";
    } elseif(!$email) {
        $_SESSION['add_user'] = "Vui lòng nhập email";
    } elseif(strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
        $_SESSION['add_user'] = "Mật khẩu phải chứa ít nhất 8 ký tự";
    } elseif(!$avatar['name']) {
        $_SESSION['add_user'] = "Vui lòng chọn ảnh đại diện";
    } else {
        // check if password don't match
        if($createpassword !== $confirmpassword) {
            $_SESSION['add_user'] = "Mật khẩu không trùng khớp";
        } else {
            // hash password
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

            // check if username or email already exists in the database
            $user_check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
            $user_check_result = mysqli_query($connection, $user_check_query);
            if(mysqli_num_rows($user_check_result) > 0) {
                $_SESSION['add_user'] = "Tên người dùng hoặc Email đã tồn tại";
            } else {
                // work on avatar
                // rename avatar
                $time = time(); // make each image name unique using current timestamp
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = '../images/' . $avatar_name;

                // make sure file is an image
                $allowed_files = ['jpg', 'jpeg', 'png', 'gif'];
                $extention = explode('.', $avatar_name);
                $extention = end($extention);
                if(in_array($extention, $allowed_files)) {
                    // make sure image is not too large
                    if($avatar['size'] < 1000000) {
                        // upload avatar
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    } else {
                        $_SESSION['add_user'] = "Kích thước file quá lớn. Vui lòng chọn file nhỏ hơn 1MB";
                    }
                } else {
                    $_SESSION['add_user'] = "File phải là jpg, jpeg, png hoặc gif";
                }
            }
        }
    }

    // redirect back to add_user page if there was any problem
    if(isset($_SESSION['add_user'])) {
        // pass form data back to add_user page
        $_SESSION['add_user_data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/add_user.php');
        die();
    } else {
        // insert new user into users table
        $insert_user_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin) VALUES ('$firstname', '$lastname', '$username', '$email', '$hashed_password', '$avatar_name', '$is_admin')";
        
        $insert_user_result = mysqli_query($connection, $insert_user_query);

        if(!mysqli_errno($connection)) {
            // redirect to login page with success message
            $_SESSION['add_user_success'] = "Người dùng $firstname $lastname đã được thêm thành công";
            header('location: ' . ROOT_URL . 'admin/manage_users.php');
            die();
        }
    }

} else {
    // if button wasn't clicked, bounce back to add_user page
    header('Location: ' . ROOT_URL . 'admin/add_user.php');
    die();
}



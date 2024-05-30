<?php
require 'config/constants.php';

// get back form data if there was a registration error
$firstname = $_SESSION['signup_data']['firstname'] ?? null;
$lastname = $_SESSION['signup_data']['lastname'] ?? null;
$username = $_SESSION['signup_data']['username'] ?? null;
$email = $_SESSION['signup_data']['email'] ?? null;
$createpassword = $_SESSION['signup_data']['createpassword'] ?? null;
$confirmpassword = $_SESSION['signup_data']['confirmpassword'] ?? null;
// delete signup data session
unset($_SESSION['signup_data']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
    <link rel="stylesheet" href="<?= ROOT_URL ?>./css/style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>

<section class="form_section">
    <div class="container form_section_container">
        <h2>Đăng ký</h2>
        <?php if(isset($_SESSION['signup'])) : ?>
            <div class="alert_message error">
                <p>
                    <?= $_SESSION['signup'];
                    unset($_SESSION['signup']); 
                    ?>
                </p>
            </div>
        <?php endif ?>
        <form action="<?= ROOT_URL?>signup_logic.php" enctype="multipart/form-data" method="POST">
            <input type="text" name="firstname" value="<?= $firstname ?>" placeholder="Tên của bạn">
            <input type="text" name="lastname" value="<?= $lastname ?>" placeholder="Họ của bạn">
            <input type="text" name="username" value="<?= $username ?>" placeholder="Tên người dùng">
            <input type="email" name="email" value="<?= $email ?>" placeholder="Email">
            <input type="password" name="createpassword" value="<?= $createpassword ?>" placeholder="Tạo mật khẩu">
            <input type="password" name="confirmpassword" value="<?= $confirmpassword ?>" placeholder="Nhập lại mật khẩu">
            <div class="form_control">
                <label for="avatar">Chọn ảnh đại diện</label>
                <input type="file" name="avatar" id="avatar">
            </div>
            <button type="submit" name="submit" class="btn">Đăng ký</button>
            <small class="small">Bạn đã có tài khoản ?<a href="signin.php">Đăng nhập</a></small>
        </form>
    </div>
</section>

</body>
</html>
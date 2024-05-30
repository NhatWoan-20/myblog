<?php
require 'config/constants.php';

$username_email = $_SESSION['signin_data']['username_email'] ?? null;
$password = $_SESSION['signin_data']['password'] ?? null;

unset($_SESSION['signin_data']);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập tài khoản</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>

<section class="form_section">
    <div class="container form_section_container">
        <h2>Đăng nhập</h2>
        <?php if(isset($_SESSION['signup_success'])) : ?>
            <div class="alert_message success">
                <p>
                    <?= $_SESSION['signup_success'];
                    unset($_SESSION['signup_success']); 
                    ?>
                </p>
            </div>
            <?php elseif(isset($_SESSION['signin'])) : ?>
            <div class="alert_message error">
                <p>
                    <?= $_SESSION['signin'];
                    unset($_SESSION['signin']); 
                    ?>
                </p>
            </div>
        <?php endif ?>
        <form action="<?= ROOT_URL ?>signin_logic.php" method="POST">
            <input type="text" name="username_email" value="<?= $username_email ?>" placeholder="Tên người dùng hoặc Email">
            <input type="password" name="password" value="<?= $password ?>" placeholder="Mật khẩu">
            <button type="submit" name="submit" class="btn">Đăng nhập</button>
            <small class="small">Bạn chưa có tài khoản ?<a href="signup.php">Đăng ký</a></small>
        </form>
    </div>
</section>

</body>
</html>
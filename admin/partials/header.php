<?php
require './config/database.php';

if(!isset($_SESSION['user_id'])) {
    header('Location: '. ROOT_URL . 'signin.php');
    die();
}

// fetch current user from database
if(isset($_SESSION['user_id'])) {
    $id = filter_var($_SESSION['user_id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT avatar FROM users WHERE id = $id";
    $result = mysqli_query($connection, $query);
    $avatar = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog of NQ</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
    <nav>
        <div class="container nav_container">
            <a href="<?= ROOT_URL ?>" class="nay_logo">BLOGNQ</a>
            <ul class="nav_items">
                <li><a href="<?= ROOT_URL ?>blog.php">Blog</a></li>
                <li><a href="<?= ROOT_URL ?>admin/add_post.php">Thêm bài viết</a></li>
                <?php if(isset($_SESSION['user_id'])) : ?>
                    <li class="nav_profile">
                        <div class="avatar">
                            <img src="<?= ROOT_URL . 'images/' . $avatar['avatar'] ?>" alt="">
                        </div>
                        <ul>
                            <li><a href="<?= ROOT_URL ?>admin/index.php">Dashboard</a></li>
                            <li><a href="<?= ROOT_URL ?>logout.php">Logout</a></li>
                        </ul>
                    </li>
                <?php else :?>
                <li><a href="<?= ROOT_URL ?>signin.php">Đăng nhập</a></li>
                <?php endif;?>
            </ul>
        </div>
    </nav>

    <!--====================== End Of Nav ===========================-->
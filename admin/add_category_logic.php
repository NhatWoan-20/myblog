<?php
require 'config/database.php';

if(isset($_POST['submit'])) {
    // get form data
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if(!$title) {
        $_SESSION['add_category'] = "Nhập vào tiêu đề.";
    } elseif(!$description) {
        $_SESSION["add_category"] = "Nhập vào mô tả.";
    }

    // redirect back to add category page with form data if there was invalid input
    if(isset($_SESSION['add_category'])) {
        $_SESSION['add_category_data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/add_category.php');
        die();
    } else {
        // insert category into database
        $query = "INSERT INTO categories (title, description) VALUES ('$title', '$description')";
        $result = mysqli_query($connection, $query);
        if(mysqli_errno($connection)) {
            $_SESSION['add_category'] = "Không thể thêm thể loại $title.";
            header('location: ' . ROOT_URL . 'admin/add_category.php');
            die();
        } else {
            $_SESSION['add_category_success'] = "Thêm thể loại $title thành công.";
            header('location: ' . ROOT_URL . 'admin/manage_categories.php');
            die();
        }
    }

}
?>
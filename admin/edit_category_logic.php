<?php
require 'config/database.php';

if(isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if(!$title || !$description) {
        $_SESSION['edit_category'] = 'Tiêu đề hoặc mô tả không được để trống';
    } else {
        $query = "UPDATE categories SET title = '$title', description = '$description' WHERE id = $id";
        $result = mysqli_query($connection, $query);

        if(mysqli_errno($connection)) {
            $_SESSION['edit_category'] = "Không thể cập nhật thể loại.";
        } else {
            $_SESSION['edit_category_success'] = "Cập nhật thể loại $title thành công";
        }
    }
}

header('location: ' . ROOT_URL . 'admin/manage_categories.php');
die();
?>
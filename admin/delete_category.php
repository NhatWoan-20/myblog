<?php
require 'config/database.php';

if(isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // delete post from database belong to category
    $delete_query = "DELETE FROM posts WHERE category_id = $id";
    $delete_result = mysqli_query($connection, $delete_query);

    if(!mysqli_errno($connection)) {
            // delete category
        $query = "DELETE FROM categories WHERE id = $id LIMIT 1";
        $result = mysqli_query($connection, $query);
        $_SESSION['delete_category_success'] = "Xóa thể loại thành công";
    }
}

header('location: ' . ROOT_URL . 'admin/manage_categories.php');
die();
?>
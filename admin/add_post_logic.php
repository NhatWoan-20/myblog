<?php 
require 'config/database.php';

if(isset($_POST['submit'])) {
    $author_id = $_SESSION['user_id'];
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    // set is featured to 0 if unchecked
    $is_featured = isset($is_featured) ? 1 : 0;
 
    // validate from data
    if(!$title) {
        $_SESSION['add_post'] = "Vui lòng nhập vào tiêu đề";
    } elseif(!$category_id) {
        $_SESSION["add_post"] = "Vui lòng chọn thể loại";
    } elseif(!$body) {
        $_SESSION["add_post"] = "Vui lòng nhập nội dung bài viết";
    } elseif(!$thumbnail['name']) {
        $_SESSION["add_post"] = "Vui lòng chọn hình ảnh";
    } else {
        // work on thumbnail
        // rename image
        $time = time();
        $thumbnail_name = $time . $thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = '../images/' . $thumbnail_name;

        $allowed_files = ['png', 'jpg', 'jpeg', 'gif'];
        $extention = explode('.', $thumbnail_name);
        $extention = end($extention);
        if(in_array($extention, $allowed_files)) {
            // make sure image is not too big
            if($thumbnail['size'] < 2000000) {
                move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
            } else {
                $_SESSION['add_post'] = "Kích thước hình ảnh quá lớn";
            }
        } else {
            $_SESSION['add_post'] = "File phải có định dạng là png, jpg, jpeg hoặc gif";
        }
    }

    // redirect back (with form data) to add_post page if there is any problem
    if(isset($_SESSION['add_post'])) {
        $_SESSION['add_post_data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/add_post.php');
        die();
    } else {
        // set is featured of all posts to 0 if is featurred for this post is 1
        if($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE posts SET is_featured = 0";
            $zero_all_is_featured_result = mysqli_query($connection, $zero_all_is_featured_query);
        }

        // insert post into database
        $query = "INSERT INTO posts (title, body, thumbnail, category_id, author_id, is_featured) VALUES ('$title', '$body', '$thumbnail_name', $category_id, $author_id, $is_featured)";
        $result = mysqli_query($connection, $query);

        if(!mysqli_errno($connection)) {
            $_SESSION["add_post_success"] = "Bài viết mới đã được thêm thành công.";
            header('location: ' . ROOT_URL . 'admin/');
            die();
        }
    }
}

header('location: ' . ROOT_URL . 'admin/add_post.php');
die();
?>
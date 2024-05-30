<?php 
require 'config/database.php';

// make sure edit post button was clicked
if(isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $previous_thumbnail_name = filter_var($_POST['previous_thumbnail_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    // set is featured to 0 if unchecked
    $is_featured = $is_featured == 1 ? : 0;

    // check and validate input values
    if(!$title) {
        $_SESSION['edit_post'] = "Không thể cập nhật bài viết. Dữ liệu không hợp lệ.";
    } elseif(!$category_id) {
        $_SESSION['edit_post'] = "Không thể cập nhật bài viết. Dữ liệu không hợp lệ.";
    } elseif(!$body) {
        $_SESSION['edit_post'] = "Không thể cập nhật bài viết. Dữ liệu không hợp lệ.";
    } else {
        if($thumbnail['name']) {
            $previous_thumbnail_path = '../images/' . $previous_thumbnail_name;
            if(file_exists($previous_thumbnail_path)) {
                unlink($previous_thumbnail_path);
            }

            // work on new thumbnail
            // rename image
            $time = time();
            $thumbnail_name = $time . $thumbnail['name'];
            $thumbnail_tmp_name = $thumbnail['tmp_name'];
            $thumbnail_destination_path = '../images/' . $thumbnail_name;

            // make sure file is an image
            $allowed_files = ['png', 'jpg', 'jpeg', 'gif'];
            $extention = explode('.', $thumbnail_name);
            $extention = end($extention);
            if(in_array($extention, $allowed_files)) {
                // make sure image is not too big
                if($thumbnail['size'] < 2000000) {
                    move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
                } else {
                    $_SESSION['edit_post'] = "Không thể cập nhật bài viết. Kích thước hình ảnh quá lớn.";
                }
            } else {
                $_SESSION['edit_post'] = "Không thể cập nhật bài viết. File phải có định dạng là png, jpg, jpeg or gif.";
            }
        }
    }

    if($_SESSION['edit_post']) {
        header('location: ' . ROOT_URL . 'admin/');
        die();
    } else {
        // set is featured of all posts to 0 if is featurred for this post is 1
        if($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE posts SET is_featured=0";
            $zero_all_is_featured_result = mysqli_query($connection, $zero_all_is_featured_query);
        }

        // set thumbnail name if a new  one was uploaded, else keep old thumbnail name
        $thumbnail_to_insert = $thumbnail_name ?? $previous_thumbnail_name;

        $query = "UPDATE posts SET title='$title', body='$body', category_id=$category_id, is_featured=$is_featured, thumbnail='$thumbnail_to_insert' WHERE id=$id LIMIT 1";
        $result = mysqli_query($connection, $query);
    }

    if(!mysqli_errno($connection)) {
        $_SESSION['edit_post_success'] = "Bài viết đã được cập nhật thành công.";
        
    }
}

header('location: '. ROOT_URL. 'admin/');
die();
?>
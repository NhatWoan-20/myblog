<?php
include './partials/header.php';

// fetch current user's posts from database
$current_user_id = $_SESSION['user_id'];
$query = "SELECT id, title, category_id FROM posts WHERE author_id = $current_user_id ORDER BY id DESC";
$posts = mysqli_query($connection, $query);
?>
<section class="dashboard">
    <?php if(isset($_SESSION['add_post_success'])) : ?>
        <div class="alert_message success container">
                <p>
                    <?= $_SESSION['add_post_success'];
                    unset($_SESSION['add_post_success']); 
                    ?>
                </p>
        </div>
    <?php elseif(isset($_SESSION['edit_post_success'])) : ?>
        <div class="alert_message success container">
                <p>
                    <?= $_SESSION['edit_post_success'];
                    unset($_SESSION['edit_post_success']); 
                    ?>
                </p>
        </div>
    <?php elseif(isset($_SESSION['edit_post'])) : ?>
        <div class="alert_message error container">
                <p>
                    <?= $_SESSION['edit_post'];
                    unset($_SESSION['edit_post']); 
                    ?>
                </p>
        </div>
    <?php elseif(isset($_SESSION['delete_post_success'])) : ?>
        <div class="alert_message success container">
                <p>
                    <?= $_SESSION['delete_post_success'];
                    unset($_SESSION['delete_post_success']); 
                    ?>
                </p>
        </div>
    <?php endif;?>
    <div class="container dashboard_container">
        <aside>
            <ul>
                <li>
                    <a href="add_post.php"><i class="uil uil-pen"></i>
                        <h5>Thêm bài viết</h5>
                    </a>
                </li>
                <li>
                    <a href="index.php" class="active"><i class="uil uil-postcard"></i>
                        <h5>Quản lí bài viết</h5>
                    </a>
                </li>
                <?php if(isset($_SESSION['user_is_admin'])) : ?>
                <li>
                    <a href="add_user.php"><i class="uil uil-user-plus"></i>
                        <h5>Thêm người dùng</h5>
                    </a>
                </li>
                <li>
                    <a href="manage_users.php"><i class="uil uil-users-alt"></i>
                        <h5>Quản lí người dùng</h5>
                    </a>
                </li>
                <li>
                    <a href="add_category.php"><i class="uil uil-edit"></i>
                        <h5>Thêm thể loại</h5>
                    </a>
                </li>
                <li>
                    <a href="manage_categories.php"><i class="uil uil-list-ul"></i>
                        <h5>Quản lí thể loại</h5>
                    </a>
                </li>
                <?php endif;?>
            </ul>
        </aside>
        <main>
            <h2>Quản lí bài viết</h2>
            <?php if(mysqli_num_rows($posts)> 0) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Tiêu đề</th>
                        <th>Thể loại</th>
                        <th>Chỉnh sửa</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($post = mysqli_fetch_assoc($posts)) : ?>
                        <!-- get category title of each post from categories table -->
                        <?php 
                        $category_id = $post['category_id'];
                        $category_query = "SELECT title FROM categories WHERE id = $category_id";
                        $category_result = mysqli_query($connection, $category_query);
                        $category = mysqli_fetch_assoc($category_result);
                        ?>
                        <tr>
                            <td><?= $post['title'] ?></td>
                            <td><?= $category['title'] ?></td>
                            <td><a href="<?= ROOT_URL ?>admin/edit_post.php ? id=<?= $post['id'] ?>" class="btn sm">Chỉnh sửa</a></td>
                            <td><a href="<?= ROOT_URL ?>admin/delete_post.php ? id=<?= $post['id'] ?>" class="btn sm danger">Xóa</a></td>
                        </tr>
                    <?php endwhile;?>
                </tbody>
            </table>
            <?php else : ?>
                <div class="alert_message error"><?= "Không tìm thấy bài viết nào." ?></div>
            <?php endif; ?>
        </main>
    </div>
</section>


<?php
include '../partials/footer.php';
?>

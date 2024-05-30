<?php
include './partials/header.php';

// fetch categories from database
$query = "SELECT * FROM categories ORDER BY title";
$categories = mysqli_query($connection, $query);
?>

<section class="dashboard">
    <?php if(isset($_SESSION['add_category_success'])) : ?>
        <div class="alert_message success container">
                <p>
                    <?= $_SESSION['add_category_success'];
                    unset($_SESSION['add_category_success']); 
                    ?>
                </p>
        </div>
    <?php elseif(isset($_SESSION['add_category'])) : ?>
        <div class="alert_message error container">
                <p>
                    <?= $_SESSION['add_category'];
                    unset($_SESSION['add_category']); 
                    ?>
                </p>
        </div>
    <?php elseif(isset($_SESSION['edit_category_success'])) : ?>
        <div class="alert_message success container">
                <p>
                    <?= $_SESSION['edit_category_success'];
                    unset($_SESSION['edit_category_success']); 
                    ?>
                </p>
        </div>
    <?php elseif(isset($_SESSION['edit_category'])) : ?>
        <div class="alert_message error container">
                <p>
                    <?= $_SESSION['edit_category'];
                    unset($_SESSION['edit_category']); 
                    ?>
                </p>
        </div>
    <?php elseif(isset($_SESSION['delete_category_success'])) : ?>
        <div class="alert_message success container">
                <p>
                    <?= $_SESSION['delete_category_success'];
                    unset($_SESSION['delete_category_success']); 
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
                    <a href="index.php"><i class="uil uil-postcard"></i>
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
                    <a href="manage_categories.php" class="active"><i class="uil uil-list-ul"></i>
                        <h5>Quản lí thể loại</h5>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </aside>
        <main>
            <h2>Quản lí thể loại</h2>
            <?php if(mysqli_num_rows($categories) > 0) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Tiêu đề</th>
                        <th>Chỉnh sửa</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($category = mysqli_fetch_assoc($categories)) : ?>
                        <tr>
                            <td><?= $category['title'] ?></td>
                            <td><a href="<?= ROOT_URL ?>admin/edit_category.php ? id=<?= $category['id'] ?>" class="btn sm">Chỉnh sửa</a></td>
                            <td><a href="<?= ROOT_URL ?>admin/delete_category.php ? id=<?= $category['id'] ?>" class="btn sm danger">Xóa</a></td>
                        </tr>
                    <?php endwhile;?>
                </tbody>
            </table>
            <?php else : ?>
                <div class="alert_message error"><?= "Không tìm thấy thể loại nào." ?></div>
            <?php endif; ?>    
        </main>
    </div>
</section>

<?php
include '../partials/footer.php';
?>

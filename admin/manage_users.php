<?php
include './partials/header.php';

// fetch users from database but not current user
$current_admin_id = $_SESSION['user_id'];

$query = "SELECT * FROM users WHERE NOT id=$current_admin_id";
$users = mysqli_query($connection, $query);

?>
<section class="dashboard">
    <?php if(isset($_SESSION['add_user_success'])) : ?>
        <div class="alert_message success container">
                <p>
                    <?= $_SESSION['add_user_success'];
                    unset($_SESSION['add_user_success']); 
                    ?>
                </p>
        </div>
    <?php elseif(isset($_SESSION['edit_user_success'])) : ?>
        <div class="alert_message success container">
                <p>
                    <?= $_SESSION['edit_user_success'];
                    unset($_SESSION['edit_user_success']); 
                    ?>
                </p>
        </div>
    <?php elseif(isset($_SESSION['edit_user'])) : ?>
        <div class="alert_message error container">
                <p>
                    <?= $_SESSION['edit_user'];
                    unset($_SESSION['edit_user']); 
                    ?>
                </p>
        </div>
    <?php elseif(isset($_SESSION['delete_user_success'])) : ?>
        <div class="alert_message success container">
                <p>
                    <?= $_SESSION['delete_user_success'];
                    unset($_SESSION['delete_user_success']); 
                    ?>
                </p>
        </div>
    <?php elseif(isset($_SESSION['delete_user'])) : ?>
        <div class="alert_message error container">
                <p>
                    <?= $_SESSION['delete_user'];
                    unset($_SESSION['delete_user']); 
                    ?>
                </p>
        </div>
    <?php endif ?>
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
                    <a href="manage_users.php" class="active"><i class="uil uil-users-alt"></i>
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
            <h2>Quản lí người dùng</h2>
            <?php if(mysqli_num_rows($users )> 0) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Họ tên</th>
                        <th>Tên người dùng</th>
                        <th>Chỉnh sửa</th>
                        <th>Xóa</th>
                        <th>Quyền Admin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($user = mysqli_fetch_assoc($users)) : ?>
                    <tr>
                        <td><?= "{$user['lastname']} {$user['firstname']}"  ?></td>
                        <td><?= $user['username'] ?></td>
                        <td><a href="<?= ROOT_URL ?>admin/edit_user.php ? id=<?= $user['id'] ?>" class="btn sm">Chỉnh sửa</a></td>
                        <td><a href="<?= ROOT_URL ?>admin/delete_user.php ? id=<?= $user['id'] ?>" class="btn sm danger">Xóa</a></td>
                        <td><?= $user['is_admin'] ? 'Yes' : 'No' ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php else : ?>
                <div class="alert_message error"><?= "Không tìm thấy người dùng nào." ?></div>
            <?php endif; ?>
        </main>
    </div>
</section>

<?php
include '../partials/footer.php';
?>

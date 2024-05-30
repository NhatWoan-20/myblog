<?php
include './partials/header.php';

// get bavk form data if there was an error
$firstname = $_SESSION['add_user_data']['firstname'] ?? null;
$lastname = $_SESSION['add_user_data']['lastname'] ?? null;
$username = $_SESSION['add_user_data']['username'] ?? null;
$email = $_SESSION['add_user_data']['email'] ?? null;
$createpassword = $_SESSION['add_user_data']['createpassword'] ?? null;
$confirmpassword = $_SESSION['add_user_data']['confirmpassword'] ?? null;


// delete session data
unset($_SESSION['add_user_data']);

?>
<section class="form_section">
    <div class="container form_section_container">
        <h2>Thêm người dùng</h2>
        <?php if(isset($_SESSION['add_user'])) : ?>
            <div class="alert_message error">
                <p>
                    <?= $_SESSION['add_user'];
                    unset($_SESSION['add_user']);
                    ?>
                </p>
            </div>
        <?php endif ?>
        <form action="<?= ROOT_URL ?>admin/add_user_logic.php" enctype="multipart/form-data" method="POST">
            <input type="text" name="firstname" value="<?= $firstname ?>"  placeholder="Tên">
            <input type="text" name="lastname"  value="<?= $lastname ?>" placeholder="Họ">
            <input type="text" name="username"  value="<?= $username ?>" placeholder="Tên người dùng">
            <input type="email" name="email"  value="<?= $email ?>" placeholder="Email">
            <input type="password" name="createpassword" value="<?= $createpassword ?>" placeholder="Tạo mật khẩu">
            <input type="password" name="confirmpassword" value="<?= $confirmpassword ?>" placeholder="Nhập lại mật khẩu">
            <select name="userrole">
                <option value="0">Author</option>
                <option value="1">Admin</option>
            </select>
            <div class="form_control">
                <label for="avatar">Chọn ảnh đại diện</label>
                <input type="file" name="avatar" id="avatar">
            </div>
            <button type="submit" name="submit" class="btn">Thêm người dùng</button>
        </form>
    </div>
</section>

<?php
include '../partials/footer.php';
?>

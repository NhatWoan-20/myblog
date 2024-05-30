<?php
include './partials/header.php';

if(isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM users WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($result);
} else {
    header('location: ' . ROOT_URL . 'admin/manage_users.php');
    die();
}
?>

<section class="form_section">
    <div class="container form_section_container">
        <h2>Chỉnh sửa người dùng</h2>
        <form action="<?= ROOT_URL ?>admin/edit_user_logic.php" method="POST">
            <input type="hidden" name="id" value="<?= $user['id'] ?>">
            <input type="text" value="<?= $user['firstname'] ?>" name="firstname" placeholder="Tên mới">
            <input type="text" value="<?= $user['lastname'] ?>" name="lastname" placeholder="Họ mới">
            <select name="userrole">
                <option value="0">Author</option>
                <option value="1">Admin</option>
            </select>
            <!-- <div class="form_control">
                <label for="avatar">Change Avatar</label>
                <input type="file" id="avatar">
            </div> -->
            <button type="submit" name="submit" class="btn">Câp nhật</button>
        </form>
    </div>
</section>

<?php
include '../partials/footer.php';
?>

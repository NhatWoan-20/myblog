<?php
include './partials/header.php';

if(isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // fetch category from database
    $query = "SELECT * FROM categories WHERE id = $id";
    $result = mysqli_query($connection, $query);
    if(mysqli_num_rows($result) == 1) {
        $category = mysqli_fetch_assoc($result);
    }
} else {
    header('location: ' . ROOT_URL . 'admin/manage_categories.php');
}
?>
<section class="form_section">
    <div class="container form_section_container">
        <h2>Chỉnh sửa thể loại</h2>
        <form action="<?= ROOT_URL ?>admin/edit_category_logic.php" method="POST">
            <input type="hidden" name="id" value="<?= $category['id']?>">
            <input type="text" name="title" value="<?= $category['title'] ?>" placeholder="Tiêu đề">
            <textarea rows="4" name="description" placeholder="Mô tả"><?= $category['description'] ?></textarea>
            <button type="submit" name="submit" class="btn">Cập nhật</button>
        </form>
    </div>
</section>

<?php
include '../partials/footer.php';
?>

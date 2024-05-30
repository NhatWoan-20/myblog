<?php
include './partials/header.php';

// fetch categories from database
$query = 'SELECT * FROM categories';
$categories = mysqli_query($connection, $query);

// get back form data if form was invalid
$title = $_SESSION['add_post_data']['title'] ?? null;
$body = $_SESSION['add_post_data']['body'] ?? null;

// delete form data session
unset($_SESSION['add_post_data']);

?>
<section class="form_section">
    <div class="container form_section_container">
        <h2>Thêm bài viết</h2>
        <?php if(isset($_SESSION['add_post'])) : ?>
            <div class="alert_message error">
                <p>
                    <?= $_SESSION['add_post'];
                    unset($_SESSION['add_post']);
                    ?>
                </p>
            </div>
        <?php endif ?>
        <form action="<?= ROOT_URL ?>admin/add_post_logic.php" enctype="multipart/form-data" method="POST">
            <input type="text" name="title" value="<?= $title ?>" placeholder="Tiêu đề">
            <select name="category">
                <?php while($category = mysqli_fetch_assoc($categories)) : ?>
                    <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
                <?php endwhile;?>
            </select>
            <textarea rows="16" name="body" placeholder="Nội dung"><?= $body ?></textarea>
            <?php if(isset($_SESSION['user_is_admin'])) : ?>
                <div class="form_control inline">
                    <input type="checkbox" name="is_featured" value="1" id="is_featured" checked>
                    <label for="is_featured">Nổi bật</label>
                </div>
            <?php endif;?>
            <div class="form_control">
                <label for="thumbnail">Chọn hình ảnh</label>
                <input type="file" name="thumbnail" id="thumbnail">
            </div>
            <button type="submit" name="submit" class="btn">Thêm bài viết</button>
        </form>
    </div>
</section>
 
<?php
include '../partials/footer.php';
?>

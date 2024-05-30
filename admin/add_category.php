<?php
include './partials/header.php';

// get back horm data if invalid
$title = $_SESSION['add_category_data']['title'] ?? null;
$description = $_SESSION['add_category_data']['description'] ?? null;

unset($_SESSION['add_category_data']);
?>
<section class="form_section">
    <div class="container form_section_container">
        <h2>Thêm thể loại</h2>
        <?php if(isset($_SESSION['add_category'])) : ?>
            <div class="alert_message error">
                <p>
                    <?= $_SESSION['add_category'];
                    unset($_SESSION['add_category']);
                    ?>
                </p>
            </div>
        <?php endif; ?>
        <form action="<?= ROOT_URL ?>admin/add_category_logic.php" method="POST">
            <input type="text" name="title" value="<?= $title ?>" placeholder="Tiêu đề">
            <textarea rows="10" name="description" value="<?= $description ?>" placeholder="Mô tả"></textarea>
            <button type="submit" name="submit" class="btn">Thêm thể loại</button>
        </form>
    </div>
</section>

<?php
include '../partials/footer.php';
?>

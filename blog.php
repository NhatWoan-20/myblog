<?php
include 'partials/header.php';
// fetch featured posts from database
$featured_query = "SELECT * FROM posts WHERE is_featured = 1";
$featured_result = mysqli_query($connection, $featured_query);
$featured = mysqli_fetch_assoc($featured_result);

// fetch all posts from posts table
$posts_query = "SELECT * FROM posts ORDER BY date_time DESC";
$posts = mysqli_query($connection, $posts_query);
?>

    <section class="search_bar">
        <form action="<?= ROOT_URL ?>search.php" class="container search_bar_container" method="GET">
            <div>
                <i class="uil uil-search"></i>
                <input type="search" name="search" placeholder="Search">
            </div>
            <button type="submit" name="submit" class="btn">Go</button>
        </form>
    </section>

    <!--====================== End Of Search Bar ===========================-->


    <section class="posts">
        <div class="container post_container">
            <?php while($post = mysqli_fetch_assoc($posts)) : ?>
                <article class="post">
                    <div class="post_thumbnail">
                        <img src="./images/<?= $post['thumbnail'] ?>" alt="">
                    </div>
                    <div class="post_info">
                        <?php 
                            //fetch category from categories table using category_id of post
                            $category_id = $post['category_id'];
                            $category_query = "SELECT * FROM categories WHERE id = $category_id";
                            $category_result = mysqli_query($connection, $category_query);
                            $category = mysqli_fetch_assoc($category_result);
                        ?>
                        <a href="<?= ROOT_URL ?>category_posts.php ? id=<?= $post['category_id'] ?>" class="category_button"><?= $category['title'] ?></a>
                        <h3 class="post_title">
                            <a href="<?= ROOT_URL ?>post.php ? id=<?= $post['id'] ?>"><?= $post['title'] ?></a>
                        </h3>
                        <p class="post_body">
                            <?= substr($post['body'], 0, 150) ?>...
                        </p>
                        <div class="post_author">
                            <?php
                                // fetch author from users table using author_id
                                $author_id = $featured['author_id'];
                                $author_query = "SELECT * FROM users WHERE id = $author_id";
                                $author_result = mysqli_query($connection, $author_query);
                                $author = mysqli_fetch_assoc($author_result); 
                            ?>
                            <div class="post_author_avatar">
                                <img src="./images/<?= $author['avatar'] ?>" alt="">
                            </div>
                            <div class="post_author_info">
                                <h5>By: <?= "{$author['lastname']} {$author['firstname']}" ?></h5>
                                <small>
                                    <?= date("M d, Y - H:i", strtotime($post['date_time'])) ?>
                                </small>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
    </section>

    <!--====================== End Of Posts ===========================-->

    <section class="category_buttons">
        <div class="container category_buttons_container">
            <?php
                $all_categories_query = "SELECT * FROM categories";
                $all_categories = mysqli_query($connection, $all_categories_query);
            ?>
            <?php while($category = mysqli_fetch_assoc($all_categories)) : ?>
                <a href="<?= ROOT_URL ?>category_posts.php ? id=<?= $category['id'] ?>" class="category_button"><?= $category['title'] ?></a>
            <?php endwhile; ?>
        </div>
    </section>
    
    <!--====================== End Of Category Buttons ===========================-->

<?php
include 'partials/footer.php';
?>
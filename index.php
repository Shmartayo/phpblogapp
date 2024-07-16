<?php
    include "partials/header.php";
    // fetch featured post from database
    $featured_query = "SELECT * FROM posts WHERE is_featured = 1";
    $featured_result = mysqli_query($conn,$featured_query);
    $featured_post = mysqli_fetch_assoc($featured_result);

    // fetch 9 posts from posts table
    $posts_query = "SELECT * FROM posts ORDER BY date_time DESC LIMIT 9";
    $posts_result = mysqli_query($conn, $posts_query);
    $posts = mysqli_fetch_all($posts_result, MYSQLI_ASSOC);
?>
    <!-- Show featured Post if there is any -->
    <?php if(mysqli_num_rows($featured_result) == 1) : ?>
    <section class="featured">
        <div class="container featured__container">
            <div class="post__thumbnail">
                <img src="images/<?= $featured_post['thumbnail'] ?>">
            </div>
            <div class="post__info">
                <!-- Fetch category -->
                <?php
                    $id = $featured_post['category_id'];
                    $category_query = "SELECT title, id FROM categories WHERE id=$id";
                    $category_result =mysqli_query($conn, $category_query);
                    $category = mysqli_fetch_assoc($category_result);
                    $category_title =  $category['title'];
                    $category_id =  $category['id'];
                ?>
                <a href="<?= ROOT_URL ?>category-posts.php?=<?= $category_id ?>" class="category__button"><?= $category_title ?></a>
                <h2 class="post__title"><a href="<?= ROOT_URL ?>posts.php?id=<?= $featured_post['id'] ?>"><?= $featured_post['title'] ?></a></h2>
                <p class="post__body"><?= substr($featured_post['body'], 0, 200) ?>...</p>
                <div class="post__author">
                    <!-- Fetch user thumbnail and name using author_id  from users table-->
                    <?php 
                        $id = $featured_post['author_id'];
                        $author_query = "SELECT * FROM users WHERE id=$id";
                        $author_result =mysqli_query($conn, $author_query);
                        $author = mysqli_fetch_assoc($author_result);
            
                    ?>
                    <div class="post__author-avatar">
                        <img src="./images/<?= $author['avatar'] ?>">
                    </div>
                    <div class="post__author-info">
                        <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?> </h5>
                        <small><?= $featured_post['date_time'] ?></small>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif ?>
    <!-- End of featured post section -->

    <section class="posts <?= $featured ?'':'section__extra-margin'; ?>" >
        <div class="container posts__container">
            <!-- Loop through the posts array and display result -->
            <?php foreach($posts as $post) : ?>
            <?php 
                
                $author_id = $post['author_id'];
                $category_id = $post['category_id'];

                $category_query_1 = "SELECT title FROM categories WHERE id=$category_id";
                $category_result_1 = mysqli_query($conn, $category_query_1);
                $category_1 = mysqli_fetch_assoc($category_result_1);

                $author_query_1 = "SELECT firstname, lastname, avatar FROM users WHERE id=$author_id";
                $author_result_1 = mysqli_query($conn, $author_query_1);
                $author_1 = mysqli_fetch_assoc($author_result_1);
            ?>
            <article class="post">
                <div class="post__thumbnail">
                    <img src="./images/<?=$post['thumbnail']?>" >
                </div> 
                <div class="post__info">
                    <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $post['category_id']; ?>" class="category__button"><?= $category_1['title'] ?></a>
                    <h3 class="post__title"><a href="<?= ROOT_URL?>posts.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a></h3>
                    <p class="post__body"><?= substr($post['body'], 0, 200)?>...</p>
                    <div class="post__author">
                        <div class="post__author-avatar">
                            <img src="./images/<?= $author_1['avatar'] ?>">
                        </div>
                        <div class="post__author-info">
                            <h5>By:  <?= "{$author_1['firstname']} {$author_1['lastname']}" ?> </h5>
                            <small><?=$post['date_time']?></small>
                        </div>
                    </div>
                </div>

            </article>
            <?php endforeach ?>
        </div>
    </section>
    <!-- End of General post section -->
        
    <section class="category__buttons">
        <div class="container category__buttons-container">
            <?php
                $all_categories_query =  "SELECT * FROM categories";
                $all_categories_result = mysqli_query($conn, $all_categories_query);
                $categories = mysqli_fetch_all($all_categories_result, MYSQLI_ASSOC);
            ?>
            <?php foreach($categories as $category): ?>
            <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $category['id'] ?>" class="category__button"><?= $category['title'] ?></a>
            <?php endforeach ?>
        </div>
    </section>
    <!-- End of Category Buttons -->
     
<?php
    include "./partials/footer.php";
?>
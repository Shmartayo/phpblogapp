<?php 
    include "./partials/header.php";

    
    // fetch all posts from posts table
    $posts_query = "SELECT * FROM posts ORDER BY date_time DESC";
    $posts_result = mysqli_query($conn, $posts_query);
    $posts = mysqli_fetch_all($posts_result, MYSQLI_ASSOC);
?>
 
    <section class="search__bar">
        <form action="<?= ROOT_URL ?>search.php" class="container search__bar-container" method="get">
            <div>
                <i class="uil uil-search"></i>
                <input type="search" name="search" placeholder="Search">
            </div>
            <button type="submit" name="submit" class="btn">Go</button>
        </form>
    </section>
    <!-- END OF Search -->

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
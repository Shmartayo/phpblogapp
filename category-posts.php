<?php 
    include "partials/header.php";

    //Check if there is an id in the url
    if(isset($_GET['id'])){
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

        $query = "SELECT * FROM posts WHERE category_id=$id ORDER BY date_time DESC";
        $result = mysqli_query($conn,$query);
        $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

    } else {
        header('location: ' . ROOT_URL);
        die();
    }

?>
    
    <header class="category__title">
        
        <h2>
            <?php
                //fetch category from categories table using category_id of post
                $category_id = $id;
                $category_query = "SELECT * FROM categories WHERE id=$id";
                $category_result = mysqli_query($conn, $category_query);
                $category = mysqli_fetch_assoc($category_result);

                echo $category['title'];
            ?>
        </h2>

    </header>
    <!-- END OF NAV -->

    <?php if(mysqli_num_rows($result) > 0) : ?>
    <section class="posts">
        <div class="container posts__container">
            <!-- Loop through the posts array and display result -->
            <?php foreach($posts as $post) : ?>
                <?php 
                
                $author_id = $post['author_id'];

                $author_query_1 = "SELECT firstname, lastname, avatar FROM users WHERE id=$author_id";
                $author_result_1 = mysqli_query($conn, $author_query_1);
                $author_1 = mysqli_fetch_assoc($author_result_1);
            ?>
            <article class="post">
                <div class="post__thumbnail">
                    <img src="./images/<?=$post['thumbnail']?>" >
                </div> 
                <div class="post__info">
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
    <?php else : ?>
            <div class="alert__message error lg">
                <?= "NO POST's FOUND FOR THIS CATEGORY"  ?>
            </div>
        <?php endif ?>

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
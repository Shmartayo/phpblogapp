<?php
    require "partials/header.php";

    //check if user entered a search and clicked the submit button
    if(isset($_GET['submit']) && isset($_GET['search'])){
        $search = filter_var($_GET['search'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        //generate query
        $query = "SELECT * FROM posts WHERE title LIKE '%$search%' ORDER BY date_time DESC";
        $result = mysqli_query($conn, $query);
        $posts = mysqli_fetch_all($result,MYSQLI_ASSOC);
    } else {
        header('location: ' .ROOT_URL .'blog.php');
        die();
    }
?>

<?php if(mysqli_num_rows($result) > 0): ?>
<section class="posts section__extra-margin">
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
                <img src="./images/<?=$post['thumbnail']?>">
            </div>
            <div class="post__info">
                <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $post['category_id']; ?>"
                    class="category__button"><?= $category_1['title'] ?></a>
                <h3 class="post__title"><a
                        href="<?= ROOT_URL?>posts.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a></h3>
                <p class="post__body"><?= substr($post['body'], 0, 200)?>...</p>
                <div class="post__author">
                    <div class="post__author-avatar">
                        <img src="./images/<?= $author_1['avatar'] ?>">
                    </div>
                    <div class="post__author-info">
                        <h5>By: <?= "{$author_1['firstname']} {$author_1['lastname']}" ?> </h5>
                        <small><?=$post['date_time']?></small>
                    </div>
                </div>
            </div>

        </article>
        <?php endforeach ?>
    </div>
</section>
<?php else : ?>
    <div class="alert__message error lg section__extra-margin ">
        <p><?= "$search Post Does Not Exist"  ?></p>
    </div>
<?php endif ?>

<section class="category__buttons">
    <div class="container category__buttons-container">
        <?php
                $all_categories_query =  "SELECT * FROM categories";
                $all_categories_result = mysqli_query($conn, $all_categories_query);
                $categories = mysqli_fetch_all($all_categories_result, MYSQLI_ASSOC);
            ?>
        <?php foreach($categories as $category): ?>
        <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $category['id'] ?>"
            class="category__button"><?= $category['title'] ?></a>
        <?php endforeach ?>
    </div>
</section>

<?php
    require "partials/footer.php";
?>
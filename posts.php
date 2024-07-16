<?php 
    include "partials/header.php";
    //Set the post from the database if the id is set
    if(isset($_GET['id'])){
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $post_query = "SELECT * FROM posts WHERE id=$id";
        $post_result = mysqli_query($conn, $post_query);
        $post = mysqli_fetch_assoc($post_result);
        mysqli_free_result($post_result);
    }else {
        header('location: ' . ROOT_URL);
        die();
    }
?>


    <section class="singlepost">
        <div class="container singlepost__container">
            <h2><?= $post['title'] ?></h2>
            <div class="post__author">
                <?php
                    // fetch author details
                    $id = $post['author_id'];
                    $author_query = "SELECT * FROM users WHERE id=$id";
                    $author_result = mysqli_query($conn, $author_query);
                    $author = mysqli_fetch_assoc($author_result);
                ?>
                <div class="post__author-avatar">
                    <img src="./images/<?= $author['avatar'] ?>" alt="">
                </div>
                <div class="post__author-info">
                    <h5>By: <?= "{$author['firstname']} {$author['lastname']} "?></h5>
                    <small><?= $post['date_time'] ?></small>
                </div>
            </div>
            <div class="singlepost__thumbnail">
                <img src="./images/<?= $post['thumbnail'] ?>">
            </div>
            <p>
                <?= $post['body'] ?>
            </p>
        </div>
    </section>
    <!-- END OF Single Post -->

<?php 
    include "./partials/footer.php";
?>
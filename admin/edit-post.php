<?php 
    include "partials/header.php";

    // Fetch categories from database
    $category_query = "SELECT * FROM categories";
    $result = mysqli_query($conn,$category_query);
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // You would need to get the id to access the edit post page
    if(isset($_GET['id'])){
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        //Fetch this current posts data from the database
        $current_post_query = "SELECT * FROM posts WHERE id= $id";
        $current_post_result = mysqli_query($conn,$current_post_query);
        $post = mysqli_fetch_assoc($current_post_result); 
    } else {
        header('location: ' . ROOT_URL . 'admin/index.php');
        die();
    }
?>
    <section class="form__section">
        <div class="container form__selection-container">
            <h2 class="formh2">Edit Post</h2>
            <form action="<?= ROOT_URL ?>admin/edit-post-logic.php" enctype="multipart/form-data" method="post">
                <input type="hidden" name="id" value="<?= $id ?>" >
                <input type="hidden" name="previous_thumbnail_name" value="<?= $post['thumbnail'] ?>" >
                <input type="text" name="title"  value="<?= $post['title']?>" placeholder="Title">
                <select name="category-id">
                    <?php foreach($categories as $category) : ?>
                    <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
                    <?php endforeach ?>
                </select>
                <textarea rows="4" name="body" placeholder="Body"><?= $post['body'] ?></textarea>
                <?php if(isset($_SESSION['user_is_admin'])) : ?>
                <div class="form__control inline">
                    <input type="checkbox" name="is_featured"  value="1" id="is_featured" checked>
                    <label for="is_featured">Featured</label>
                </div>
                <?php endif ?>
                <div class="form__control">
                    <label for="thumbnail" >Change Thumbnail</label>
                    <input type="file" name="thumbnail" id="thumbnail">
                </div>
                <button type="submit" name="submit" class="btn">Update Post</button>
            </form>
        </div>
    </section>
    <!-- END OF FORM -->
<?php 
    include "../partials/footer.php";
?>
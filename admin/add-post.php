<?php 
    include "partials/header.php";

    // fetch all categories
    $query = "SELECT * FROM categories";
    $result = mysqli_query($conn, $query);
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $post_data = $_SESSION['add-post-data'] ?? "";

    unset($_SESSION['add-post-data']);
?>
    <section class="form__section">
        <div class="container form__selection-container">
            <h2 class="formh2">Add Post</h2>
            <?php if(isset($_SESSION['add-post'])) : ?>
            <div class="alert__message error">
                <p>
                    <?=
                        $_SESSION['add-post'];
                        unset($_SESSION['add-post'])
                    ?>
                </p>
            </div>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>admin/add-post-logic.php" enctype="multipart/form-data" method="post">
                <input type="text" name="title" value="<?= $post_data['title'] ?? ""?>" placeholder="Title">
                <select name="category">
                    <?php foreach($categories as $category) : ?>
                    <option value="<?= $category['id']?>"><?= $category['title'] ?></option>
                    <?php endforeach ?>
                </select>
                <textarea rows="4" name="body" placeholder="Body"><?= $post_data['body'] ?? ""?></textarea>
                <?php if(isset($_SESSION['user_is_admin'] )) : ?>
                <div class="form__control inline">
                    <input type="checkbox" name="is_featured" value="1" id="is_featured" checked>
                    <label for="is_featured">Featured</label>
                </div>
                <?php endif ?>
                <div class="form__control">
                    <label for="thumbnail">Add Thumbnail</label>
                    <input type="file" name="thumbnail" id="thumbnail">
                </div>
                <button type="submit" name="submit" class="btn">Add Post</button>
            </form>
        </div>
    </section>
    <!-- END OF FORM -->
<?php 
    include "../partials/footer.php";
?>
<?php 
    include  "partials/header.php";
    $data = $_SESSION['add-category-data'] ?? "";
    unset($_SESSION['add-category-data']);
?>

    <section class="form__section">
        <div class="container form__selection-container">
            <h2 class="formh2">Add Category</h2>
            <?php if(isset($_SESSION['add-category'])): ?>
            <div class="alert__message error">
                <p>
                    <?= $_SESSION['add-category'];
                    
                        unset($_SESSION['add-category']);
                    ?>
                </p>
            </div>
            <?php endif ?>
            <form action="<?= ROOT_URL?>admin/add-category-logic.php" method="post">
                <input type="text" name="title" value="<?= $data['title'] ?? ""; ?>" placeholder="Title">
                <textarea rows="4" name="description"  placeholder="Description"><?= $data['description'] ?? ""; ?></textarea>
                <button type="submit"  name="submit" class="btn">Add Category</button>
            </form>
        </div>
    </section>
    <!-- END OF FORM -->
<?php 
    include "../partials/footer.php";
?>
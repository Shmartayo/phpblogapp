<?php 
    include "partials/header.php";

    // To access the category page you need to have an id 
    if(isset($_GET['id'])){
        // Get the id cause you would use it to query the datavase
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

        // use the id to get the current category

        $query = "SELECT * FROM categories WHERE id = $id";
        $result = mysqli_query($conn,$query);
        //Check if it is only one value
        if(mysqli_num_rows($result) == 1){
            $category = mysqli_fetch_assoc($result);
        }

    } else {
        header('location: ' . ROOT_URL . 'admin/manage-category.php');
        die();
    }
?>
    <section class="form__section">
        <div class="container form__selection-container">
            <h2 class="formh2">Edit Category</h2>
            <form action="edit-category-logic.php" method="post">
                <input type="hidden" name="id" value="<?= $category['id'] ?>" placeholder="Title">
                <input type="text" name="title" value="<?= $category['title'] ?>" placeholder="Title">
                <textarea rows="4" name="description" placeholder="Description"><?= $category['description'] ?></textarea>
                <button type="submit" name="submit" class="btn">Update Category</button>
            </form>
        </div>
    </section>
    <!-- END OF FORM -->
<?php 
    include "../partials/footer.php";
?>
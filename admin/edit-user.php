<?php 
    include "partials/header.php";


    // For you to access the edit page you should have an id in your url
    if(isset($_GET['id'])){
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

        //Use id to fetch current selected user's input
        $query = "SELECT * FROM users WHERE id = $id";
        $result= mysqli_query($conn, $query);

        $user = mysqli_fetch_assoc($result);

    } else {
        header('location: ' . ROOT_URL . 'admin/manage-users.php');
    }
?>

<section class="form__section">

    <div class="container form__selection-container">
        <h2 class="formh2">Edit User</h2>
        <?php if (isset($_SESSION['edit-user'])): // shows if add user was successful ?>
        <div class="alert__message error container">
            <p>
                <?= $_SESSION['edit-user'];
                    unset($_SESSION['edit-user']);
                ?>
            </p>
        </div>
        <?php endif ?>
        <form action="<?= ROOT_URL ?>admin/edit-user-logic.php" method="post">
            <input type="hidden" name="id" value="<?= $user['id'] ?>">
            <input type="text" name="firstname" value="<?= $user['firstname'] ?>" placeholder="First Name">
            <input type="text" name="lastname" value="<?= $user['lastname'] ?>" placeholder="Last Name">
            <label for="">User Role</label>
            <select name="is_admin">
                <option value="0">Author</option>
                <option value="1">Admin</option>
            </select>

            <button type="submit" name="submit" class="btn">Update User</button>
        </form>
    </div>
</section>
<!-- END OF FORM -->
<?php 
    include "../partials/footer.php";
?>
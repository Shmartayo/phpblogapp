<?php 
    include "partials/header.php";
    $error = $_SESSION['add-user'];
    $user = $_SESSION['add-user-data'] ?? "";
    unset($_SESSION['add-user-data']);

?>
    <section class="form__section">
        <div class="container form__selection-container">
            <h2 class="formh2">Add User</h2>
            <?php if(isset($error)) : ?>
            <div class="alert__message error">
                <p>
                    <?= $error;
                        unset($_SESSION['add-user']);

                         
                    ?>
                </p>
            </div>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>admin/add-user-logic.php" method="post" enctype="multipart/form-data">
                <input type="text" name="firstname" value="<?= $user['firstname'] ?? "" ?>" placeholder="First Name">
                <input type="text" name="lastname" value="<?= $user['lastname'] ?? ""?>" placeholder="Last Name">
                <input type="text" name="username" value="<?= $user['username']?? ""  ?>" placeholder="Username">
                <input type="email" name="email" value="<?= $user['email'] ?? ""?>" placeholder="Email">
                <input type="password" name="createpassword" value="<?= $user['createpassword']?? "" ?>" placeholder="Create Password">
                <input type="password" name="confirmpassword" value="<?= $user['confirmpassword']?? ""  ?>" placeholder="Confirm Password">
                <select name="is_admin">
                    <option value="0">Author</option>
                    <option value="1">Admin</option>
                </select>
                <div class="form__control">
                    <label for="avatar">User Avatar</label>
                    <input type="file" id="avatar" name="avatar">
                </div>
                <button type="submit" name="submit" class="btn">Add User</button>
            </form>
        </div>
    </section>
    <!-- END OF FORM -->
<?php 
    include "../partials/footer.php";
?>
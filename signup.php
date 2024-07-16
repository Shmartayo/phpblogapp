<?php
    require "config/constants.php";

    //Get back form data if there was a registration error
    $firstname = $_SESSION['signup-data']['firstname'] ?? "";
    $lastname = $_SESSION['signup-data']['lastname'] ?? "";
    $username = $_SESSION['signup-data']['username'] ?? "";
    $email = $_SESSION['signup-data']['email'] ?? "";
    $createpassword = $_SESSION['signup-data']['createpassword'] ?? "";
    $confirmpassword = $_SESSION['signup-data']['confirmpassword'] ?? "";
    
    //Delete signup data session
    unset($_SESSION['signup-data']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP & MySQL Blog Application with admin Panel</title>
    <!-- Custom stylesheet -->
    <link rel="stylesheet" href="css/style.css">
    <!-- FONT AWESOME CDN -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">

    <!-- Google Fonts (Montserrat)-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>

    <section class="form__section">
        <div class="container form__selection-container">
            <h2 class="formh2">Sign Up</h2>
            <!-- Check if there are any errors -->
            <?php if(isset($_SESSION['signup'])) : ?>
                <div class="alert__message error">
                    <p>
                        <?php 
                        // Display error message
                        echo $_SESSION['signup'];

                        // Delete session error varaible
                        unset($_SESSION['signup']);
                        ?>
                    </p>
                </div>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>signup-logic.php" method="post" enctype="multipart/form-data">
                <input type="text" name="firstname" value="<?= $firstname ?>" placeholder="First Name">
                <input type="text" name="lastname" value="<?= $lastname ?>" placeholder="Last Name">
                <input type="text" name="username" value="<?= $username ?>" placeholder="Username">
                <input type="email" name="email" value="<?= $email ?>" placeholder="Email">
                <input type="password" name="createpassword" value="<?= $createpassword?>" placeholder="Create Password">
                <input type="password" name="confirmpassword" value="<?= $confirmpassword ?>" placeholder="Confirm Password">
                <div class="form__control">
                    <label for="avatar">User Avatar</label>
                    <input type="file" name="avatar" id="avatar" placeholder="First Name">
                </div>
                <button type="submit" name="submit" class="btn">Sign Up</button>
                <small>Already have an account? <a href="signin.php">Sign In</a></small>
            </form>
        </div>
    </section>

</body>
</html>
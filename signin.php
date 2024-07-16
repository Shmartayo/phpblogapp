<?php 
    require 'config/database.php';
    $username_email = $_SESSION['signin-data']['username_email'] ?? "";
    unset($_SESSION['signin-data']);
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
            <h2 class="formh2">Sign In</h2>
            <?php if(isset($_SESSION['signup-success'])) : ?>
                <div class="alert__message success">
                    <p>
                        <?php
                            echo $_SESSION['signup-success'];
                            unset($_SESSION['signup-success'])
                        ?>
                    </p>
                </div>
            <?php elseif(isset($_SESSION['signin'])): ?>
                <div class="alert__message error">
                    <p>
                        <?php
                            echo $_SESSION['signin'];
                            unset($_SESSION['signin'])
                        ?>
                    </p>
                </div>
            <?php endif ?>
            <form action="signin-logic.php" method="post">
                <input type="text" name="username_email" value="<?= $username_email ?>" placeholder="Username or Email">
                <input type="password" name="password" placeholder="Password">
                <button type="submit" name="submit" class="btn">Sign In</button>
                <small>Don't have an account? <a href="signup.php">Sign Up</a></small>
            </form>
        </div>
    </section>

</body>
</html>
<?php
    require "config/database.php";
    
        // fetch current user from database
        if(isset($_SESSION['user-id'])){
            $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $query = "SELECT avatar FROM users WHERE id = '$id'";
            $result = mysqli_query($conn, $query);
            $avatar = mysqli_fetch_assoc($result);
         }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP & MySQL Blog Application with admin Panel</title>
    <!-- Custom stylesheet -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css">
    <!-- FONT AWESOME CDN -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">

    <!-- Google Fonts (Montserrat)-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <nav>
        <div class="container nav__container">
            <a href="<?= ROOT_URL ?>" class="nav__logo">EGATOR</a>
            <ul class="nav__items">
                <li><a href="<?= ROOT_URL ?>blog.php">Blog</a></li>
                <li><a href="<?= ROOT_URL ?>about.php">About</a></li>
                <li><a href="<?= ROOT_URL ?>services.php">Services</a></li>
                <li><a href="<?= ROOT_URL ?>contact.php">Contact</a></li>
                <?php if(isset($_SESSION['user-id'])) : ?>
                <li class="nav__profile">
                    <div class="avatar">
                    <img src="<?= ROOT_URL . 'images/' . $avatar['avatar']?>" alt="avatar">
                    </div>
                    <ul>
                        <li><a href="<?php echo ROOT_URL ?>admin/">Dashboard</a></li>
                        <li><a href="<?php echo ROOT_URL ?>logout.php">Logout</a></li>
                    </ul>
                </li>
                <?php else : ?>
                <li><a href="<?php echo ROOT_URL ?>signin.php" class="btn">Sign in</a></li>
                <?php endif ?>
            </ul>
            <button id="open__nav-btn"><i class="uil uil-bars"></i></button>
            <button id="close__nav-btn"><i class="uil uil-multiply"></i></button>
        </div>
    </nav>
    <!-- END OF NAV -->
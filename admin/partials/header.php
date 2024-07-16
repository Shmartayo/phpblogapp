<?php 
    //Access control(Logout) would happen in this header
    // Require header from main code 
    require "../partials/header.php";

    /* Check if the user id is not in a session then you 
        would be logged out and redirect the user 
       back to the sign in page 
    */
    if(!isset($_SESSION['user-id'])){
        header('location: ' . ROOT_URL . 'signin.php');
        die();
    }
?>
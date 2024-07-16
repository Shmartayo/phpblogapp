<?php 
    require "config/constants.php";
    // Destroy all sessions and Redirect to the home page 
    session_destroy();
    header('location: ' .ROOT_URL);
    die();
        
?>
<?php 

    require "partials/header.php";

    if(isset($_POST['submit'])){
        //Get updated form data 
        $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
        $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $is_admin  = filter_var($_POST['is_admin'], FILTER_SANITIZE_NUMBER_INT);

        //check for valid input
        if(!$firstname || !$lastname ){
            $_SESSION['edit-user'] = 'Invalid form input on edit page.';
            header('location: ' . ROOT_URL . "admin/edit-user.php?id=$id");
        } else {
            // Update User
            $query = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', is_admin = $is_admin WHERE id = $id LIMIT 1";
            $result = mysqli_query($conn, $query);
        }

        //Check if there are any errors with the connection
        if(!mysqli_errno($conn)){
            $_SESSION['edit-user-success'] = "$firstname $lastname updated Successfully";
            header('location: ' . ROOT_URL . 'admin/manage-users.php');
            die();
        } else {
            $_SESSION['edit-user'] = 'Failed to update user';
        }


    } else {
        header('location: ' . ROOT_URL . 'admin/edit-user.php');
        die();
    }


?>
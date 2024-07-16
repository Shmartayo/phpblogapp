<?php
    /* 
        Since we are getting the gettimg the id we are going to grab the avatar name to delete
        it from the uploaded files.
    */

    require "config/database.php";

    if(isset($_GET['id'])){
        //Fetch User from database

        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        
        $query = "SELECT * FROM users WHERE id = $id LIMIT 1";
        $result = mysqli_query($conn, $query);
        $user = mysqli_fetch_assoc($result);

        //Make sure we got back only one user
        if(mysqli_num_rows($result) == 1){
            //First delete user avatar
            //Get name of avatar

            $avatar_name = $user['avatar'];

            //Get Path to avatar in the project
            $avatar_path = '../images/' . $avatar_name;

            //Delete image if available 
            if($avatar_path){
                //delete avatar from images folder
                unlink($avatar_path);
            }
        } 

        /*  
            FOR LATER
            fetch all thumbnails of user's post's and delete them
        */
        $thumbnails_query = "SELECT thumbnail FROM posts WHERE author_id=$id";
        $thumbnails_result = mysqli_query($conn,$thumbnails_query);
        $thumbnails = mysqli_fetch_all($thumbnails_result, MYSQLI_ASSOC);
        //check if there are any results result returned from the query
        if(mysqli_num_rows($thumbnails_result) > 0){
            foreach($thumbnails as $thumbnail){
                //Get each thumbnail path 
                $thumbnail_path = '../images/'. $thumbnail['thumbnail'];
                // check if path exist to thumbnail
                if($thumbnail_path){
                    //Delete thumbnail from images folder
                    unlink($thumbnail_path);
                }
            }
        }

        // Delete user from database
        $delete_user_query = "DELETE FROM users WHERE id = $id";
        $delete_user_result = mysqli_query($conn, $delete_user_query);

        if(mysqli_errno($conn)){
            $_SESSION['delete-user'] = "Error deleting {$user['firstname']} {$user['lastname']}";
        } else {
            $_SESSION['delete-user-success'] = "Successfully  deleted {$user['firstname']} {$user['lastname']}";
            header('location: ' . ROOT_URL . 'admin/manage-users.php');
            die();
        }
    } else {
        header('location: ' . ROOT_URL . 'admin/manage-users.php');
    }







?>
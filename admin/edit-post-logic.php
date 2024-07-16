<?php
    require "config/database.php";

    // check if submit button was clicked
    if(isset($_POST['submit'])){
        //Filter amd samitize data 
        $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
        $previous_thumbnail_name = filter_var($_POST['previous_thumbnail_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $category_id = filter_var($_POST['category-id'], FILTER_SANITIZE_NUMBER_INT);
        $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
        $thumbnail = $_FILES['thumbnail']; 

        //set is_featured to 0 if unchecked 
        $is_featured = $is_featured == 1 ?: 0;

        //check and validate input values
        if(!$title || !$category_id || !$body){
            $_SESSION['edit-post'] = "Couldn't Update Post. Invalid form data on edit post page";
        } else {

            // Delete existing thumbnail from database and images folder if new thumbnail is available
            if($thumbnail['name']){
                $previous_thumbnail_path = '../images/' . $previous_thumbnail_name;
                if($previous_thumbnail_path){
                    unlink($previous_thumbnail_path);
                }

                //Work on new thumbnail
                //rename
                //set path
                //set tmp name

                $time = time();
                $thumbnail_name = $time . $thumbnail['name'];
                $thumbnail_tmp_name = $thumbnail['tmp_name'];
                $thumbnail_destination_path = '../images/' . $thumbnail_name;


                //check if extemsiom is im allowed files amd size of file too

                $allowed_files= array('png', 'jpg', 'jpeg');
                $extension = explode('.', $thumbnail_name);
                $extension = end($extension);

                // check if in array
                if(in_array($extension, $allowed_files)){
                    // check if file size is less than 2mb
                    if($thumbnail['size'] < 2000000){
                        move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
                    } else {
                        $_SESSION['edit-post'] = "File size too large, must be less than 2mb";
                    }
                } else {
                    $_SESSION['edit-post'] = "File type not supported, must be jpeg, jpg, png";
                }
            }
        }

        //Check if there are any errors
        if(isset($_SESSION['edit-post'])){
            $_SESSION['edit-post-data'] = $_POST;
            header('location: ' . ROOT_URL . 'admin/');
            die();
        } else {
            // set is_featured of all post to 0 if current post is_featured
            if($is_featured == 1){
                $zero_all_is_featured_query = "UPDATE posts SET is_featured=0 ";
                $zero_all_is_featured_result = mysqli_query($conn, $zero_all_is_featured_query); 

                //using null coallescing operator to set thumbnail name if a new one was uploaded, else keep old thumbnail name
                $thumbnail_to_insert = $thumbnail_name ?? $previous_thumbnail_name;

                //Insert data into database

                $update_query = "UPDATE posts SET title = '$title', body = '$body', is_featured =$is_featured, category_id=$category_id, thumbnail = '$thumbnail_to_insert' WHERE id=$id LIMIT 1 ";
                $update_result = mysqli_query($conn,$update_query);
            }

            //check if there are no errors updating the post
            if(!mysqli_errno($conn)){
                $_SESSION['edit-post-success'] = "$title Post Successfully Updated!";
            }
        }
        header('location: ' .ROOT_URL . 'admin/');
        die();

    } else {
        header('location: ' . ROOT_URL . 'admin/');
        die();
    }
?>
<?php
    require "config/database.php";

    //Make sure the id is in the url
    if(isset($_GET['id'])){
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

        //Proceed to fetch data from database
        // Because we want to delete the thumbnail that belongs
        // to that post from the images folder
        $fetch_query = "SELECT * FROM posts WHERE id = $id";
        $fetch_result = mysqli_query($conn, $fetch_query);
        $post = mysqli_fetch_assoc($fetch_result);

        //Make sure only one post was returned in the query
        if(mysqli_num_rows($fetch_result) ==1 ){
            // Get the thumbnail from the result
            $thumbnail_name = $post['thumbnail'];
            $thumbnail_path = '../images/' . $thumbnail_name;

            // if we have a valid path them we can proceed to deleting the image 
            if($thumbnail_path){
                unlink($thumbnail_path);

                //Once that is done we can proceed to delete post from database
                $delete_post_query = "DELETE FROM posts WHERE id = $id LIMIT 1";
                $delete_post_result =mysqli_query($conn, $delete_post_query);

                //if there are mo errors im the query
                if(!mysqli_errno($conn)){
                    $_SESSION['delete-post-success'] = "{$post['title']} Post Deleted Sussessfully";
                    header('location: ' . ROOT_URL . 'admin/');
                    die();
                }
            }
        }

    } else {
        header('location: ' . ROOT_URL . 'admin/');
        die();
    }

?>
<?php
    require "config/database.php";

    if(isset($_POST['submit'])){
        // Get all the form values and sanitize them
        $author_id = $_SESSION['user-id'];
        $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
        $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
        $thumbnail = $_FILES['thumbnail'];

        // set is_featured to 0 if unchecked
        $is_featured = $is_featured == 1 ?:0;

        //Validate inputs
        if(!$title){
            $_SESSION['add-post'] = 'Enter Post Title';
        } elseif(!$body){
            $_SESSION['add-post'] = 'Add Post Content';
        } elseif (!$category_id){
            $_SESSION['add-post']= 'Select Post Category';
        } elseif(!$thumbnail['name']){
            $_SESSION['add-post'] = 'Add A Post Thumbnail';
        } else {
            //work on thumbnail
            //rename thumbnail
            $time = time(); // used to make each image unique
            $thumbnail_name = $time . $thumbnail['name'];
            $thumbnail_tmp_name = $thumbnail['tmp_name'];
            $thumbnail_destination_path = '../images/' . $thumbnail_name;

            //Before uploading make sure the file is really an image
            $allowed_files = array('png','jpg','jpeg');
            $extension = explode('.', $thumbnail_name);
            $extension = end($extension);

            if(in_array($extension, $allowed_files)){
                //check the size
                if($thumbnail['size'] < 2000000){
                    move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
                } else {
                    $_SESSION['add-post'] = 'File Size Too Large, Must Be Less Than 2mb';
                }
            } else {
                $_SESSION['add-post'] = "File type not supported, should be png, jpg or jpeg";
            }
        }

        //check if there are amy errors redirect to the add post
        // page with the data
        if(isset($_SESSION['add-post'])){
            $_SESSION['add-post-data'] = $_POST;
            header('location: ' . ROOT_URL . 'admin/add-post.php');
            die();
        } else {
            // Vefore we imsert the post imto the datavase, 
            // Check if the curremt post we are tryimg to post is set 
            // featured post. If we are makimg the cdurremt post a
            // featured post them update all other post amd set the 
            // is_featured to 0, (we should have omly ome is_featured
            // post im our datavase).

            // Set is_feature of all other posts to o if curremt post
            //is_featured

            if($is_featured == 1){
                $zero_all_is_featured_query = "UPDATE posts SET is_featured = 0";
                $zero_all_is_featured_result = mysqli_query($conn, $zero_all_is_featured_query);
            }

            // save data to database

            $query = "INSERT INTO posts(title, body, thumbnail, category_id, author_id, is_featured) VALUES ('$title', '$body', '$thumbnail_name', $category_id, $author_id, $is_featured)";
            $result = mysqli_query($conn,$query);

            if(!mysqli_errno($conn)){
                $_SESSION['add-post-success'] = "$title Successfully Posted";
                header('location: ' . ROOT_URL . 'admin/');
                die();
            } 
        }
    } else {
        header('location: ' .ROOT_URL . 'admin/manage-post.php');
    }
?>
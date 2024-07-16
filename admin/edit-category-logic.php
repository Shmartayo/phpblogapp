<?php 
    require "config/database.php";
    if(isset($_POST['submit'])){
        //save filtered and sanitized values to variable
   

        $id= filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
        $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        //validate inputs from user
        if(!$title){
            $_SESSION['edit-category'] = "Enter Title";
        } elseif (!$description){
            $_SESSION['edit-category'] = "Enter Description";
        } else {
            //Insert category in database
            $query = "UPDATE categories SET title ='$title', description = '$description' WHERE id = $id LIMIT 1";
            $result = mysqli_query($conn, $query);
            
            if(mysqli_errno($conn)){
                $_SESSION['edit-category'] = "Failed to add $title category";
            } else {
               //display a success message in the manage category page
                $_SESSION['edit-category-success'] = "$title Category Updated Successfully";
           }
        }
    } 
    header('location: ' . ROOT_URL . 'admin/manage-category.php');
    die();
?>
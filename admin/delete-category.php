<?php

    require "config/database.php";

    if(isset($_GET['id'])){
        //Fetch Category from database

        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        

        // FOR LATER
        // Update category_id of posts that belong
        // to this category to id of uncategorized category
        $update_query = "UPDATE posts SET category_id=10 WHERE category_id=$id";
        $update_result = mysqli_query($conn, $update_query);

        //check if there were no errors
        if(!mysqli_errno($conn)){
            //This is just for displaying the title of the deleted category
            $query = "SELECT title FROM categories WHERE id=$id LIMIT 1";
            $result = mysqli_query($conn, $query);
            $category = mysqli_fetch_assoc($result);

 
            // Delete category from database
            $delete_category_query = "DELETE FROM categories WHERE id=$id LIMIT 1";
            $delete_category_result = mysqli_query($conn, $delete_category_query);
            $_SESSION['delete-category-success'] = "Successfully  Deleted {$category['title']} Category ";
        }
        
        header('location: ' . ROOT_URL . 'admin/manage-category.php');
        die();
        
    } else {
        header('location: ' . ROOT_URL . 'admin/manage-category.php');
    }
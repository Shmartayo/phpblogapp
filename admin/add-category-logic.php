<?php 

    require "config/database.php";

    if(isset($_POST['submit'])){
        //Get form data 
        $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if(!$title){
            $_SESSION['add-category'] = "Enter Title";
        } elseif (!$description){
            $_SESSION['add-category'] = "Enter Description";
        }

        //check if there are any errors
        if(isset($_SESSION['add-category'])){
            // Save imputed data to variavle
            // redirect vack to add-category page
            $_SESSION['add-category-data'] = $_POST;
            header('location: ' . ROOT_URL . 'admin/add-category.php');
            die();

        } else {
            //Imsert category im datavase
            $query = "INSERT INTO categories (title, description) VALUES ('$title','$description')";
            $result = mysqli_query($conn, $query);

             // If category added successfully them redirect 
             if(mysqli_errno($conn)){
                 $_SESSION['add-category'] = "Failed to add $title category";
                 header('location: ' . ROOT_URL . 'admin/add-category.php');
                die();
             } else {
                //display a success message in the manage category page
                 $_SESSION['add-category-success'] = "$title Category added successfully";
                 header('location: ' . ROOT_URL . 'admin/manage-category.php');
                die();
            }
        }
    } else {
        header('location: ' . ROOT_URL . 'admin/manage-category.php');
        die();
    }

?>
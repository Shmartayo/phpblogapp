<?php 
    require 'config/database.php';

    //Check if button was clicked
    if(isset($_POST['submit'])){ 

        // // Get form data filter and sanitize user inputs
        $username_email = filter_var($_POST['username_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        //Validate user input
        if(!$username_email){
            $_SESSION['signin'] = "Enter username or email";
        } elseif(!$password){
            $_SESSION['signin'] = "Enter your password";
        } else {
            //if all checks are validated fetch user from database
            $fetch_user_query = "SELECT * FROM users WHERE username = '$username_email' OR email = '$username_email'";
            $fetch_user_result = mysqli_query($conn, $fetch_user_query);

            // We want to check if we got only one record back
            if(mysqli_num_rows($fetch_user_result) == 1){
                /* 
                    We found a valid user,we proceed to
                    convert the record into an asscociative
                    array.
                */
                
                
                $user = mysqli_fetch_assoc($fetch_user_result);


                // //Get user password
                $db_password = $user['password'];

                //compare the password entered and the password in the database
                if(password_verify($password, $db_password)) {
                    /* 
                        We can proceed to set some session for
                        access control for our user. This is
                        what we would use to check if someone
                        is logged in(the user would have access to the
                        dashboard, the avatar and the logout).
                    */ 
                    $_SESSION['user-id'] = $user['id']; // We are going to use the ID to do alot of things
                    // Set session if user is admin
                    if($user['is_admin'] == 1){
                        $_SESSION['user_is_admin'] = true;
                    }        
                    //if password match and user is admin we can proceed to log user in
                    header('location: ' . ROOT_URL . 'admin/');        
                } else{
                    $_SESSION['signin'] = "Incorrect Password";
                }
            } else {
                $_SESSION['signin'] = "User not found";
            }
        }

        // // if there is any problem, redirect back to sign in page with login data
        if(isset($_SESSION['signin'])){
            $_SESSION['signin-data'] = $_POST;
            header('location: ' . ROOT_URL . 'signin.php');
            die();
        }
    } else {
        header('location: ' . ROOT_URL . 'signin.php');
        die();
    }
?>
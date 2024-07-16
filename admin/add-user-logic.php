<?php
    require "config/database.php";

    //  Get form data if submit button was clicked
    if(isset($_POST['submit'])){
        // // Filter and sanitize inputs
        // $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL );
        // $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // $is_admin = filter_var($_POST['is_admin'], FILTER_SANITIZE_NUMBER_INT);
        // $avatar = $_FILES['avatar'];

        // //Validate input values
        // if(!$firstname){
        //     $_SESSION['add-user'] = "Enter Your First Name";
        // } elseif (!$lastname) {
        //     $_SESSION['add-user'] = "Enter Your Last Name";
        // } elseif(!$username){
        //     $_SESSION['add-user'] = "Enter Your Username";
        // } elseif (!$email) {
        //     $_SESSION['add-user'] = "Enter Your email";
        // }  elseif($createpassword < 8 || $confirmpassword < 8){
        //     $_SESSION['add-user'] = "Password Must Be 8+ Characters or Alphanumeric";
        // } elseif (!$avatar['name']){
        //     $_SESSION['add-user'] = "Add Avatar";
        // } else {
        //     //Check if passwords don't match
        //     if($createpassword !== $confirmpassword){
        //         $_SESSION['add-user'] = "Passwords Do Not Match";
        //     } else {
        //         // hash password 
        //         $hashedpassword = password_hash($createpassword, PASSWORD_DEFAULT);

        //         //Check if username of email exists inside database

        //         $query = "SELECT * FROM users WHERE username = '$username'";
        //         $result = mysqli_query($conn, $query);

        //         if(mysqli_num_rows($result) > 0){
        //             $_SESSION['add-user'] = "User already exists";
        //         } else {

        //             //Work on avatar
        //             //rename avatar
        //             $time = time();
        //             $avatar_name = $time. $avatar['name'];
        //             $avatar_tmp_name = $avatar['tmp_name'];
        //             $avatar_destination_path = '../images/' . $avatar_name;

        //             //make sure file is am image
        //             $allowed_files = array('png', 'jpg', 'jpeg');
        //             $extention = explode('.', $avatar_name);
        //             $extention = end($extention);

        //             //upload avatar if the image file type is correct
        //             // and the size is less than 1mb
        //             if(in_array($extention, $allowed_files)){
        //                 if($avatar['size'] < 1000000){
        //                     move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
        //                 } else {
        //                     $_SESSION['add-user'] = "File size larger than 1mb";
        //                 }
        //             } else {
        //                 $_SESSION['add-user'] = "File type is mot supported";
        //             }
        //         }
        //     }
        // }
        // //Redirect vack to add-user page if there are amy errors
        // if(isset($_SESSION['add-user'])) {
        //     $_SESSION['add-user-data'] = $_POST;
        //     header('location: ' .ROOT_URL. 'admin/add-user.php');
        //     die();
        // } else {
        //     //write a query and store data into database
        //     $query = "INSERT INTO users(firstname, lastname, username, email, password, avatar, is_admin) VALUES ('$firstname','$lastname','$username', '$email', '$hashedpassword', '$avatar','$is_admin')";
        //     mysqli_query($conn, $query);

        //     if(!mysqli_errno($conn)){
        //         //Redirect to mamage-users page
        //         $_SESSION['add-user-success'] = "New User Added!";
        //         header('location: ' . ROOT_URL . 'admin/manage-users.php');
        //         die();
        //     }
        // }

        //Lets get the inputs, filter and sanitize them
        $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $is_admin = filter_var($_POST['is_admin'], FILTER_SANITIZE_NUMBER_INT);
        $avatar = $_FILES['avatar'];


        //validate input values to make sure people enter valid values
        if(!$firstname){
            $_SESSION['add-user'] = "Please enter your First Name";
        } elseif (!$lastname){
            $_SESSION['add-user'] = "Please enter your Last Name";
        } elseif (!$username) {
            $_SESSION['add-user'] = "Please enter your Username";
        } elseif (!$email) {
            $_SESSION['add-user'] = "Please enter a valid email";
        } elseif (strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
            $_SESSION['add-user'] = "Password should be  8+ characters long";
        } elseif (!$avatar['name']) {
            $_SESSION['add-user'] = "Please add avatar";
        } else {
            //Check if passwords don't match
            if($createpassword !== $confirmpassword){
                $_SESSION['add-user'] = "Passwords do not match";
            } else {
                //hash one password
                $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

                //check if the username or email exist in database
                // Step 1 -> Save the query in a  variable
                $user_check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
                
                //First lets execute the query
                $user_check_result = mysqli_query($conn, $user_check_query);

                /*
                 NOTE: if we get any row from the database then 
                 that means the username or the email is
                 already taken. 
                */

                if(mysqli_num_rows($user_check_result) > 0){
                    $_SESSION['add-user'] = "User already exists";
                } else {
                    // if it is not already taken then we proceed to work on avatar

                    // step 1 : Rename image and make it unique for each upload
                    $time = time(); // make each image name unique using current timestamp
                    $avatar_name = $time . $avatar['name'];
                    $avatar_tmp_name = $avatar['tmp_name']; // We get this to use for the uploading of avatar into the images folder
                    //Get the destination (Where you want to upload this image to)
                    $avatar_destination_path = '../images/' . $avatar_name ;

                    /* 
                        Before we upload the avatar we would have some checks 
                    */
                    // Make sure file is an image
                    $allowed_files = array('png','jpg','jpg');

                    //Get the extention of the image we are uploading
                    $extention = explode('.', $avatar['name']);
                    $extention = end($extention);

                    // Check if "$extention" is inside "$allowed_files"
                    if(in_array($extention, $allowed_files)){
                        // Make sure the image is not too large(1mb)
                        // we are going to use the size in the avatar file array
                        if($avatar['size'] < 1000000){
                            //Proceed and upload avatar
                            move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                        } else {
                            $_SESSION['add-user'] = 'Image file size too large. Should be less than 1mb';
                        }
                    } else {
                        $_SESSION['add-user'] = 'File type is not supported. File should be png,jpg or jpeg';
                    }
                }
            }
        }
        // if there is any errors, redirect to add-user page
        if(isset($_SESSION['add-user'])){
            // Pass form data back to add-user page
            $_SESSION['add-user-data'] = $_POST;
            header('location: '. ROOT_URL . 'admin/add-user.php');
            die();
        } else {
            //save to database
            $insert_user_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin) VALUES ('$firstname','$lastname','$username','$email','$hashed_password','$avatar_name', $is_admin)";
            mysqli_query($conn, $insert_user_query);

            //if everything went well (Check if the user was inserted into the database successfully)
            if(!mysqli_errno($conn)){
                //redirect to login page
                $_SESSION['add-user-success'] = "$firstname $lastname Successfuly Added";
                header('location: ' . ROOT_URL . 'admin/manage-users.php');
                die();
            }
        }
    } else {
       header('location: ' . ROOT_URL . 'admin/add-user.php') ;
       die();
    }
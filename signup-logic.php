<?php 
    require "config/database.php";

    //Get signup form data if signup button was clicked
    if(isset($_POST['submit'])){

        //Lets get the inputs, filter and sanitize them
        $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $avatar = $_FILES['avatar'];


        //validate input values to make sure people enter valid values
        if(!$firstname){
            $_SESSION['signup'] = "Please enter your First Name";
        } elseif (!$lastname){
            $_SESSION['signup'] = "Please enter your Last Name";
        } elseif (!$username) {
            $_SESSION['signup'] = "Please enter your Username";
        } elseif (!$email) {
            $_SESSION['signup'] = "Please enter a valid email";
        } elseif (strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
            $_SESSION['signup'] = "Password should be  8+ characters long";
        } elseif (!$avatar['name']) {
            $_SESSION['signup'] = "Please add avatar";
        } else {
            //Check if passwords don't match
            if($createpassword !== $confirmpassword){
                $_SESSION['signup'] = "Passwords do not match";
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
                    $_SESSION['signup'] = "Username or Email already exists";
                } else {
                    // if it is not already taken then we proceed to work on avatar

                    // step 1 : Rename image and make it unique for each upload
                    $time = time(); // make each image name unique using current timestamp
                    $avatar_name = $time . $avatar['name'];
                    $avatar_tmp_name = $avatar['tmp_name'];
                    //Get the destination (Where you want to upload this image to)
                    $avatar_destination_path = 'images/' . $avatar_name;

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
                            $_SESSION['signup'] = 'Image file size too large. Should be less than 1mb';
                        }
                    } else {
                        $_SESSION['signup'] = 'File type is not supported. File should be png,jpg or jpeg';
                    }
                }
            }
        }
        // if there is any errors, redirect to signup page
        if(isset($_SESSION['signup'])){
            // Pass form data back to sign up page
            $_SESSION['signup-data'] = $_POST;
            header('location: '. ROOT_URL . 'signup.php');
            die();
        } else {
            //save to database
            $insert_user_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin) VALUES ('$firstname','$lastname','$username','$email','$hashed_password','$avatar_name', 0)";
            mysqli_query($conn, $insert_user_query);

            //if everything went well 
            if(!mysqli_errno($conn)){
                //redirect to login page
                $_SESSION['signup-success'] = "Registration successful. Please log in";
                header('location: ' . ROOT_URL . 'signin.php' );
                die();
            }
        }
    } else {
        // if button wasn't clicked redirect back to sign up page
        header('location: '. ROOT_URL . 'signup.php');
        die();
    }

?>
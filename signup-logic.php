<?php
    
    require 'config/database.php';


    // ============== FOR SIGNUP ===============
    // get user data if signup button is clicked
    if(isset($_POST['submit'])){

        // Step 1: Sanitizing inputs
        $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // Retrieve uploaded file(avatar) info. $_FILES is a superglobal array used to handle file uploads
        $avatar = $_FILES['avatar'];
        

        // Step 2: Validate input values
        if (!$firstname) {
            $_SESSION['signup'] = "Please enter your first name.";
        } elseif (!$lastname) {
            $_SESSION['signup'] = "Please enter your last name.";
        } elseif (!$email) {
            $_SESSION['signup'] = "Please enter a valid email.";
        }elseif (strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
            $_SESSION['signup'] = "Password should be 8+ characters.";
        } elseif (!$avatar['name']) {
            $_SESSION['signup'] = "Please select an image as avatar.";
        } else {
            // Check if passwords match
            if ($createpassword !== $confirmpassword) {
                $_SESSION['signup'] = "Passwords do not match.";
            } else {
  
                // Step 3: Escape inputs for SQL
                $firstname = mysqli_real_escape_string($connection, $firstname);
                $lastname = mysqli_real_escape_string($connection, $lastname);
                $username = mysqli_real_escape_string($connection, $username);
                $email = mysqli_real_escape_string($connection, $email);
                $createpassword = mysqli_real_escape_string($connection, $createpassword);
                $confirmpassword = mysqli_real_escape_string($connection, $confirmpassword);
                
                // Hash password if they match
                $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);
                
                //check if username or email already exists in DB
                $user_exists_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
                $user_exists_result = mysqli_query($connection, $user_exists_query);
                if(mysqli_num_rows($user_exists_result)>0){
                    $_SESSION['signup'] = "Username or email already exists!";
                } else {
                    //work on avatar
                    //rename the uploaded image file so each image has a unique name using current timestamp
                    $time = time();
                    $avatar_name = $time . $avatar['name'];
                    $avatar_tmp_name = $avatar['tmp_name'];
                    $avatar_destination_path = 'images/avatar/' . $avatar_name;

                    //check the file is an image
                    $allowed_extensions = ['png', 'jpg', 'jpeg', 'jfif', 'gif', 'bmp', 'tiff', 'webp', 'svg'];
                    $extension = explode('.', $avatar_name);
                    $extension = end($extension);
                    if(in_array($extension, $allowed_extensions)){
                        //make sure image is not too large
                        if($avatar['size'] < 1000000){
                            //upload to images folder
                            move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                        } else {
                            $_SESSION['signup'] = 'File size too big! Should be less than 1Mb.';
                        }
                    } else {
                        $_SESSION['signup'] = "Invalid Image Format!";
                    }
                }
            }
        }
        
      
        // redirect to signup page on any error
        if(isset($_SESSION['signup'])){
            //pass form data back to signup page;
            $_SESSION['signup-data'] = $_POST;
            header('location: ' . ROOT_URL . 'signup.php');
            die();
        } else {

            //insert new user to DB if no error
            $insert_user_query = "INSERT INTO users (first_name, last_name, username, email, password, avatar, is_admin) VALUES('$firstname', '$lastname', '$username', '$email', '$hashed_password', '$avatar_name', 0)";
            $insert_user_result = mysqli_query($connection, $insert_user_query);
            if($insert_user_result){
                //redirect to login page with success message
                $_SESSION['signup-success'] = "User registration successful! Please log in.";
                header('location: ' . ROOT_URL . 'signin.php');
                die();
            }
        }
        
        

    } else {
        // if signup button is not clicked, bounce back to signup page
        header('location' . ROOT_URL . 'signup.php');
        die();
    }

    
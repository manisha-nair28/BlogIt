<?php
    
    require 'config/database.php';

// ============== FOR SIGNIN ===============

    if(isset($_POST['submit'])){

        // Step 1: Sanitizing inputs
        $username_email = filter_var($_POST['username_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        echo $username_email;
        // Step 2: Validate input values
        if (!$username_email) {
            $_SESSION['signin'] = "Please enter an email or a username (any one).";
        }elseif (!$password) {
            $_SESSION['signin'] = "Password field cannot be left empty.";
        }else {

            // Step 3: Escape inputs for SQL
            $username_email = mysqli_real_escape_string($connection, $username_email);
            $password = mysqli_real_escape_string($connection, $password);

            // Fetch user
            $fetch_user_query = "SELECT * FROM users WHERE username='$username_email' OR email='$username_email'";
            $fetch_user_result = mysqli_query($connection, $fetch_user_query);

            if(mysqli_num_rows($fetch_user_result)==1) {

                //convert the record into associative array
                $row = mysqli_fetch_assoc($fetch_user_result);

                //fetch hashed password
                $db_password = $row['password'];

                //if both passwords match
                if(password_verify($password, $db_password)){

                    //set session for user access control
                    $_SESSION['user-id'] = $row['id'];
                    //set session if user is an admin
                    if($row['is_admin'] == 1){
                        $_SESSION['user_is_admin'] = true;
                    }

                    // log user in
                    header('location: ' . ROOT_URL . 'admin/');
                } else {

                    $_SESSION['signin'] = "Wrong password. Enter the correct password.";
                }

            } else {
                $_SESSION['signin'] = "Username or email not found.";
            }
        }

        //if error occurs, redirect back to sign in page
        if(isset($_SESSION['signin'])) {
            //pass form data back to signin page;
            $_SESSION['signin-data'] = $_POST;
            header('location: ' . ROOT_URL . 'signin.php');
            die();
        }
        

    } else {
        header('location: ' . ROOT_URL . 'signin.php');
        die();
    }

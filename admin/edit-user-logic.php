<?php
    
    require 'config/database.php';

    // ============== FOR EDIT USER: ADMIN ===============

    // get user data if edit user button | submit button is clicked
    if(isset($_POST['submit'])){

        
        // Step 1: Sanitizing inputs
        $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
        $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);


        // Step 2: Validating inputs
        if (!$firstname || !$lastname) {
            $_SESSION['edit-user'] = "Invalid form input on edit page!";
        } else {

            // Step 3: Escape inputs for SQL
            $firstname = mysqli_real_escape_string($connection, $firstname);
            $lastname = mysqli_real_escape_string($connection, $lastname);
            $id = (int) $id;
            $is_admin = (int) $is_admin;

            // Step 4: Perform the SQL update | make sure we have only 1 record
            $query = "UPDATE users SET first_name = '$firstname', last_name = '$lastname', is_admin = $is_admin WHERE id = $id LIMIT 1";
            $result = mysqli_query($connection, $query);

            if ($result) {
                $_SESSION['edit-user-success'] = "User record for $firstname $lastname updated successfully";
            } else {
                $_SESSION['edit-user'] = "Error updating user record!";
            }

        }

        header('location: ' . ROOT_URL . 'admin/manage-users.php');
        die();
   
    } else {
        // if no button is clicked, redirect back to edit user page
        header('location' . ROOT_URL . 'admin/manage-users.php');
        die();
    }
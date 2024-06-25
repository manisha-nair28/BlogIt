<?php
    
    require 'config/database.php';

    // ============== FOR EDIT CATEGORY: ADMIN ===============

    // get user data if edit category button | submit button is clicked
    if(isset($_POST['submit'])){

        // Step 1: Sanitizing inputs
        $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
        $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // Step 2: Validating inputs
        if (!$title || !$description) {
            $_SESSION['edit-category'] = "Invalid form input for category editing!";

        } else {

            // Step 3: Escape inputs for SQL
            $title = mysqli_real_escape_string($connection, $title);
            $description = mysqli_real_escape_string($connection, $description);
            $id = (int) $id;

            // Step 4: Perform the SQL update | make sure we have only 1 record
            $query = "UPDATE categories SET title = '$title', description = '$description' WHERE id = $id LIMIT 1";
            $result = mysqli_query($connection, $query);

            if ($result) {
                $_SESSION['edit-category-success'] = "Record for category $title updated successfully";
               
            } else {
                $_SESSION['edit-category'] = "Error updating category!";
            }

        }

    header('location: ' . ROOT_URL . 'admin/manage-categories.php');
    die();


    } else {
        // if no button is clicked, redirect back to edit user page
        header('location' . ROOT_URL . 'admin/manage-categories.php');
        die();
    }
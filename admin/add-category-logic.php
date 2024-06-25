<?php
    
    require 'config/database.php';

    // ============== FOR ADD CATEGORIES: ADMIN ===============

    // get user data if Add category button | submit button is clicked
    if(isset($_POST['submit'])){

        // Step 1: Sanitizing inputs
        $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // Step 2: Validating inputs
        if(!$title){
            $_SESSION['add-category'] = "Please enter a category title name.";
        } elseif(!$description) {
            $_SESSION['add-category'] = "Please enter description for the title.";
        }

        // Step 3: Escape inputs for SQL
        $title = mysqli_real_escape_string($connection, $title);
        $description = mysqli_real_escape_string($connection, $description);

        //redirect back to category if error in inputs is present
        if(isset($_SESSION['add-category'])){
            $_SESSION['add-category-data'] = $_POST;
            header('location: ' . ROOT_URL . 'admin/add-category.php');
            die();
        } else {

            //insert category to DB
            $query = "INSERT INTO categories (title, description) VALUES('$title', '$description')"; 
            $result = mysqli_query($connection, $query);
            if(!$result){
                $_SESSION['add-category'] = "Couldn't add category!";
                header('location: ' . ROOT_URL . 'admin/add-category.php');
                die();
            } else {
                $_SESSION['add-category-success'] = "Category $title added successfully!";
                header('location: ' . ROOT_URL . 'admin/manage-categories.php');
                die(); 
            }
        }



        


    } else {
        // if no button is clicked, redirect back to add user page
        header('location' . ROOT_URL . 'admin/add-category.php');
        die();
    }
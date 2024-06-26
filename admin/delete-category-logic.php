<?php
    
    require 'config/database.php';

    // ============== FOR DELETE CATEGORY: ADMIN ===============
    //to do: backup, restore within 30 days, permanent deletion after 30 days
    //ask for confirmation
    
    if(isset($_GET['id'])){

       
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT );

        //update the category of the posts that belong to this category to 'uncategorized
        //since current category will be deleted, all posts of this category will move to 'uncategorized' category
        $update_query = "UPDATE posts SET category_id=1 WHERE category_id=$id";
        $update_result = mysqli_query($connection, $update_query);
        if(!$update_result){
            //delete user from user table
            $query = "DELETE FROM categories WHERE id=$id LIMIT 1";
            $result = mysqli_query($connection, $query);
            if(!$result){
                $_SESSION['delete-category'] = "Error! Couldn't delete category!";
            } else {
                $_SESSION['delete-category-success'] = "Category deleted successfully.";
            }
        }

      

        header('location: ' . ROOT_URL . 'admin/manage-categories.php');
        die();


    }

    
<?php
    
    require 'config/database.php';

    // ============== FOR DELETE POST: ALL USERS ===============
    //to do: backup, restore within 30 days, permanent deletion after 30 days
   
    
    if(isset($_GET['id'])){

        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT );

        //fetch post from DB to delete thumbnail from images folder
        $query = "SELECT * FROM posts WHERE id=$id";
        $result = mysqli_query($connection, $query);

        //make sure we hav only one thumbnail
        if(mysqli_num_rows($result)==1){
            $post = mysqli_fetch_assoc($result);
            $thumbnail_name = $post['thumbnail'];
            $thumbnail_path = '../images/blog_images/' . $thumbnail_name;
            //delete image if it is available
            if($thumbnail_path){
                unlink($thumbnail_path);
            }
        }

        //delete user from user table
        $delete_post_query = "DELETE FROM posts WHERE id=$id";
        $delete_post_result = mysqli_query($connection, $delete_post_query);
        if(!$delete_post_result){
            $_SESSION['delete-post'] = "Couldn't delete post!";
        } else {
            $_SESSION['delete-post-success'] = "Post deleted successfully.";
        }

    }

    header('location: ' . ROOT_URL . 'admin/');
    die();
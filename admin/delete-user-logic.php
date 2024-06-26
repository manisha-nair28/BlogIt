<?php
    
    require 'config/database.php';

    // ============== FOR DELETE USER: ADMIN ===============
    //to do: backup, restore within 30 days, permanent deletion after 30 days
    //ask for confirmation
    
    if(isset($_GET['id'])){

       
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT );

        //fetch users from DB
        $query = "SELECT * FROM users WHERE id=$id";
        $result = mysqli_query($connection, $query);
        $user = mysqli_fetch_assoc($result);

        //make sure we get one user from DB
        if(mysqli_num_rows($result)==1){
            $avatar_name = $user['avatar'];
            $avatar_path = '../images/avatar/' . $avatar_name;
            //delete image if it is available
            if($avatar_path){
                unlink($avatar_path);
            }
        }

        // delete blog
        //fetch all thumbnails of user posts and delete them
        //posts are deleted by query of mysql
        $thumbnail_query = "SELECT thumbnail FROM posts WHERE author_id=$id";
        $thumbnail_result = mysqli_query($connection, $thumbnail_query);
        if(mysqli_num_rows($thumbnail_result)>0){
            while($thumbnail = mysqli_fetch_assoc($thumbnail_result)){
                $thumbnail_path = '../images/blog_images/' . $thumbnail['thumbnail'];
                //delete thumbnail from images folder
                if($thumbnail_path){
                    unlink($thumbnail_path);
                } 
                    
            }
        }


        //delete user from user table
        $delete_user_query = "DELETE FROM users WHERE id=$id";
        $delete_user_result = mysqli_query($connection, $delete_user_query);
        if(!$delete_user_result){
            $_SESSION['delete-user'] = "Couldn't delete user '{$user['first_name']}' '{$user['last_name']}'!";
        } else {
            $_SESSION['delete-user-success'] = "User deleted successfully.";
        }
    }

    header('location: ' . ROOT_URL . 'admin/manage-users.php');
    die();
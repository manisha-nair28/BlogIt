<?php
    
    require 'config/database.php';

    // ============== FOR EDIT POST: ALL USERS ===============

    // get user data if edit category button | submit button is clicked
    if(isset($_POST['submit'])){

        // Step 1: Sanitizing inputs
        $id=filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT);
        $title=filter_var($_POST['title'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $body=filter_var($_POST['body'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $category_id=filter_var($_POST['category_id'],FILTER_SANITIZE_NUMBER_INT);
        $is_featured=filter_var($_POST['is_featured'],FILTER_SANITIZE_NUMBER_INT);
       
        $previous_thumbnail=filter_var($_POST['previous_thumbnail'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $thumbnail=$_FILES['thumbnail'];
    
        //set is_featured to zero if unchecked
        $is_featured=$is_featured == 1  ?: 0;
    
        //check and validate input values
        if(!$title){
            $_SESSION['edit-post']="Couldn't update post! Invalid blog title.";
        }elseif(!$category_id){
            $_SESSION['edit-post']="Couldn't update post! Invalid form data on edit page.";
        }elseif(!$body){
            $_SESSION['edit-post']="Couldn't update post! Invalid post body.";
        }else{
            if($thumbnail['name']){
                $previous_thumbnail_destination='../images/blog_images/' . $previous_thumbnail;
                if($previous_thumbnail_destination){
                    unlink($previous_thumbnail_destination);
                }
            
            // WORK ON NEW THUMBNAIL
            //rename image
            
            $time=time();
            $thumbnail_name=$time . $thumbnail['name'];
            $thumbnail_tmp_name=$thumbnail['tmp_name'];
            $thumbnail_destination_path="../images/blog_images/" . $thumbnail_name;
    
            //check the file is an image
            $allowed_extensions = ['png', 'jpg', 'jpeg', 'jfif', 'gif', 'bmp', 'tiff', 'webp', 'svg'];
            $extension = explode('.', $thumbnail_name);
            $extension = end($extension);
            
            if(in_array($extension,$allowed_files)){
                //make sure image is not too large.(2mb+)
                if($thumbnail['size']<2000000){
                    //upload thumbnail
                    move_uploaded_file($thumbnail_tmp_name,$thumbnail_destination_path);
    
                }else{
                    $_SESSION['edit-post']="File size too big. Should be less than 2mb";
    
                }
            }else{
                $_SESSION['edit-post']="File  should be png, jpg or jpeg";
        
            }
        }
            
    
        }
    
            // redirect to manage post if there is error in form data
        if(isset($_SESSION['edit-post'])){
    
            header('location: ' . ROOT_URL . 'admin/');
            die();
            }else{
            //set is_featured of all post is set to 0 if is_featured for this post is set to 1
            if($is_featured==1){
                $zero_all_is_featured_query="UPDATE posts SET is_featured=0";
                $zero_all_is_featured_result=mysqli_query($connection,$zero_all_is_featured_query);
            }        
            $thumbnail_to_insert= $thumbnail_name ?? $previous_thumbnail_name;
    
    
                //insert post into database
                $query="UPDATE posts SET title='$title', body='$body' ,thumbnail='$thumbnail_to_insert' ,category_id='$category_id',is_featured=$is_featured WHERE id=$id LIMIT 1";
                $result=mysqli_query($connection,$query);   
            }
    
            if(!mysqli_errno($connection)){
                $_SESSION['edit-post-success']="Post updated successfully";
            }
    }
    header('location: ' . ROOT_URL . 'admin/');
    die();
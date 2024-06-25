<?php
    
    require 'config/database.php';

    // ============== FOR ALL USERS: ADD BLOG POSTS ===============

    // get user data if Add Post button | submit button is clicked
    if(isset($_POST['submit'])){

        $author_id = $_SESSION['user-id'];

        // Step 1: Sanitizing inputs
        $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
        $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
        // is_featured attribute set to 0 if unchecked
        $is_featured = $is_featured == 1 ?:0;
        $thumbnail = $_FILES['thumbnail'];
        
        // Step 2: Validate input values
        if (!$title) {
            $_SESSION['add-post'] = "Please enter post title.";
        } elseif (!$category_id) {
            $_SESSION['add-post'] = "Please select a category for the post.";
        }elseif (!$body) {
            $_SESSION['add-post'] = "Please add body for the blog post.";
        }elseif (!$thumbnail['name']) {
            $_SESSION['add-post'] = "Please select a thumbnail.";
        }else {
            //work on thumbnail
            //rename the uploaded image file so each image has a unique name using current timestamp
            $time = time();
            $thumbnail_name = $time . $thumbnail['name'];
            $thumbnail_tmp_name = $thumbnail['tmp_name'];
            $thumbnail_destination_path = '../images/blog_images/' . $thumbnail_name;

            //check the file is an image
            $allowed_extensions = ['png', 'jpg', 'jpeg', 'jfif', 'gif', 'bmp', 'tiff', 'webp', 'svg'];
            $extension = explode('.', $thumbnail_name);
            $extension = end($extension);

            if(in_array($extension, $allowed_extensions)){

                //make sure image is not too large
                if($thumbnail['size'] < 2_000_000){
                    //upload to images folder
                    move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
                    
                    //to do: check if saved successfully
                } else {
                    $_SESSION['add-post'] = 'Thumbnail image size too big! Should be less than 2mb.';
                }
            } else {
                $_SESSION['add-post'] = "Invalid Thumbnail Image Format!";
            }
        }

        // redirect to add posts page on any error
        if(isset($_SESSION['add-post'])){
            //pass form data back to add-post page;
            $_SESSION['add-post-data'] = $_POST;
            header('location: ' . ROOT_URL . 'admin/add-post.php');
            die();
        } else {

            // if 'is_featured' option for current post is checked (i.e. set to 1), then any other featured posts should be removed (i.e. value must be set to 0)
            // i.e. there can be only one featured post at a time, other posts must be removed from featured
            // set all other posts to 0 (is_featured == 0)
            if($is_featured ==1){
                $set_to_zero_query = "UPDATE posts SET is_featured=0";
                $set_to_zero_result = mysqli_query($connection, $set_to_zero_query);

            }
           

            // Step 3: Escape inputs for SQL
            $title = mysqli_real_escape_string($connection, $title);
            $body = mysqli_real_escape_string($connection, $body);
            $thumbnail_name = mysqli_real_escape_string($connection, $thumbnail_name);

            //insert new post to DB 
            $query = "INSERT INTO posts (title, body, thumbnail, category_id, author_id, is_featured) VALUES('$title', '$body', '$thumbnail_name', '$category_id', '$author_id', '$is_featured')";
            $result = mysqli_query($connection, $query);
            if($result){
                //redirect to login page with success message
                $_SESSION['add-post-success'] = "New post added successfully!";
                header('location: ' . ROOT_URL . 'admin/');
                die();
            }
        }
        
    }

    header('location' . ROOT_URL . 'admin/add-post.php');
    die();
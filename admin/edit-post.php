<!--================== HEADER =====================-->
    <?php
        include 'partials/header.php';

        //fetch the categories from DB
        $category_query = "SELECT * FROM categories";
        $category_result = mysqli_query($connection, $category_query);
       
        //fetch blog post data from DB using id
        if(isset($_GET['id'])){

            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

            //fetch the details of post whose id is clicked
            $query = "SELECT * FROM posts WHERE id=$id";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);

        } else {
            //without post id, this page cannot be accessed; redirect back
            header('location: ' . ROOT_URL . 'admin/manage-users.php');
            die();
        }
    ?>


<section class="form__section">
    <div class="container form__section-container">
        <h2>Edit Post</h2>
        
        <form action="<?= ROOT_URL ?>admin/edit-post-logic.php" method="POST"  enctype="multipart/form-data">
            
            <!-- Hidden field containing the post id -->
            <input type="hidden" name="id" value="<?=$row['id']?>" >
            <!-- Hidden input field containing the previous thumbnail name  -->
            <input type="hidden" name="previous_thumbnail" value="<?=$row['thumbnail']?>" >


            <input type="text" name="title" value="<?=$row['title']?>" placeholder="Title">
            <select name="category">
            <?php 
                while($category = mysqli_fetch_assoc($category_result)): 
            ?>
                <option value="<?=$category['id'] ?>"><?=$category['title'] ?></option>
                
            <?php 
                    endwhile
            ?>
            </select>

            <textarea rows="10" name="body" placeholder="body"><?=$row['body']?></textarea>

            <div class="form__control inline">
                <input type="checkbox" name="is_featured" id="is_featured"  value="1" checked>
                <label for="is_featured" >Featured</label>
            </div>

            <div class="form__control">
                <label for="thumbnail">Change/Update Thumbnail</label>
                <input type="file" name="thumbnail" id="thumbnail">
            </div>

            <button type="submit" name="submit" class="btn">Update Post</button>
            
        </form>
    </div>
</section>



<!--================== FOOTER =====================-->
<?php
        include '../partials/footer.php';
    ?>
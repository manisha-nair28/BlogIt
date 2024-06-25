<!--================== HEADER =====================-->
    <?php
        include 'partials/header.php';

        if(isset($_GET['id'])){
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

            //fetch the details of category whose id is clicked
            $query = "SELECT * FROM categories WHERE id=$id";
            $result = mysqli_query($connection, $query);
            
            if(mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_assoc($result);
            }
            

        } else {
            //without user id, this page cannot be accessed; redirect back
            header('location: ' . ROOT_URL . 'admin/manage-categories.php');
            die();
        }
    ?>



<section class="form__section">
    <div class="container form__section-container">
        <h2>Edit Category</h2>
    
        <form action="<?= ROOT_URL ?>admin/edit-category-logic.php" method="POST">

            <!-- hidden input field having the category id -->
            <input type="hidden" value="<?= $row['id'] ?>" name="id" >
            <input type="text" value="<?= $row['title'] ?>" name="title" placeholder="Title">
            <textarea rows="4" name="description" placeholder="description"><?=$row['description']?></textarea>
           
            <button type="submit" name="submit" class="btn">Update Category</button>
          
        </form>
    </div>
</section>



<!--================== FOOTER =====================-->
<?php
        include '../partials/footer.php';
    ?>
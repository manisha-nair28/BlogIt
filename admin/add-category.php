<!--================== HEADER =====================-->
    <?php
        include 'partials/header.php';

        //get back form data in case of an error
        $title = $_SESSION['add-category-data']['title'] ?? null;
        $description = $_SESSION['add-category-data']['description'] ?? null;
 
        //delete from data data session
        unset($_SESSION['add-category-data']);
    ?>


<section class="form__section">
    <div class="container form__section-container">
        <h2>Add Category</h2>

        <!--==== ERROR MESSAGE FOR INVALID INPUT OR ADD CATEGORY FAILURE ====-->
        <?php
            if(isset($_SESSION['add-category'])) :
        ?>

            <div class="alert__message error">
                <p>
                    <?= $_SESSION['add-category']; 
                        unset($_SESSION['add-category']);
                    ?>
                </p>
            </div>

        <?php
            endif
        ?> 


        <form action="<?= ROOT_URL ?>admin/add-category-logic.php" method="POST">
            <input type="text" name="title" value="<?=$title ?>" placeholder="Title">
            <textarea rows="4" name="description" placeholder="description"><?=$description ?></textarea>
            <button type="submit" name="submit"  class="btn">Add Category</button>
          
        </form>
    </div>
</section>


<!--================== FOOTER =====================-->
    <?php
        include '../partials/footer.php';
    ?>
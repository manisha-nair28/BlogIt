<!--================== HEADER =====================-->
<?php
    include 'partials/header.php';

    //make sure an id is set otherwise redirect to blog.php 
    if(isset($_GET['id'])){ 

        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

        //fetch recent posts from DB belonging to category id
        $query = "SELECT posts.*, categories.title AS category_name, users.first_name, users.last_name, users.avatar 
                FROM posts 
                JOIN categories ON posts.category_id = categories.id 
                JOIN users ON posts.author_id = users.id 
                WHERE posts.category_id=$id 
                ORDER BY posts.date_time DESC";

        $result = mysqli_query($connection, $query);


        //get category name
        $category_name_query = "SELECT DISTINCT title FROM categories WHERE id =$id";
        $category_name_result = mysqli_query($connection, $category_name_query);
        $category_name_row = mysqli_fetch_assoc($category_name_result);
        

    } else {
        header('location: ' . ROOT_URL . 'blog.php');
        die();
    }

?>



    <!--=============== BEGINNING OF CATEGORY TITLE =====================-->

   <header class="category__title">
        <h2>Category:  <?=$category_name_row['title'];?> </h2>
   </header>

    <!--=============== END OF CATEGORY TITLE =====================-->
    


    <!--=============== BEGINNING OF SECTION: POSTS =====================-->

    <!--=== CHECK IF POSTS FOR THE CATEGORY EXISTS ===-->
    <?php if(mysqli_num_rows($result)>0) : ?>

    <section class="posts">

        <div class="container posts__container">

            <!-- ============ ARTICLES ============== -->

            <?php while( $row = mysqli_fetch_assoc($result)) : ?>
            <article class="post">
                
                <div class="post__thumbnail">
                    <img src="./images/blog_images/<?=$row['thumbnail']?>" alt="blog-thumbnail">
                </div>

                <div class="post__info">

                    <a href="<?=ROOT_URL?>category-posts.php?id=<?=$row['category_id']?>" class="category__button">
                        <?=$row['category_name']?>
                    </a>
                    
                    <h3 class="post__title">
                        <a href="<?=ROOT_URL?>post.php?id=<?=$row['id']?>">
                            <?=$row['title']?>
                        </a>
                    </h3>

                    <p class="post__body">
                        <?= substr($row['body'], 0, 150) ?>....
                    </p>

                    <div class="post__author">
                        <div class="post__author-avatar">
                            <img src="./images/avatar/<?=$row['avatar']?>" alt="author-image">
                        </div>
                        <div class="post__author-info">

                            <h5>
                                By:  
                                <?= 
                                    "{$row['first_name']} {$row['last_name']}"
                                ?>
                            </h5>

                            <small>
                                <?= date("M d, Y - g:i A", strtotime($row['date_time']))  ?>
                            </small>
                        </div>
                    </div>
                </div>
            </article>
            <?php endwhile ?>

        </div>     

    </section>

    <!--==== ERROR MESSAGE IF NO POST FOUND  ====-->
    <?php 
        else :
    ?>  
        <div class="alert__message error lg">
            <p>
                <?= "No posts found for category: '{$category_name_row['title']}'!" ?>
            </p>
        </div>
    <?php
        endif
    ?>
    <!--=============== END OF SECTION: POSTS =====================-->



    <!--================== BEGINNING OF SECTION: CATEGORY BUTTONS =====================-->
    <section class="category__buttons">
        <div class="container category__buttons-container">
            
            <!--=== FETCH ALL CATEGORIES FROM DB ===-->
            <?php 
                $category_query = "SELECT * FROM categories";
                $category_result = mysqli_query($connection, $category_query);
                
                while($category_row = mysqli_fetch_assoc($category_result)) :
            ?>
                <a href="<?=ROOT_URL?>category-posts.php?id=<?=$category_row['id']?>" class="category__button">
                    <?=$category_row['title']?>
                </a>
            
            <?php endwhile ?>
        </div>
    </section>
    <!--================== END OF SECTION: CATEGORY BUTTONS =====================-->
    
    <!--================== FOOTER =====================-->
    <?php
        include 'partials/footer.php';
    ?>
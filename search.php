<!--================== HEADER =====================-->
<?php 
    include 'partials/header.php';

    //check if the user entered something in the searchbar
    if(isset($_GET['search']) && isset($_GET['submit'])){

        // Step 1: Sanitizing input
        $search = filter_var($_GET['search'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // Step 2: Escape input for SQL
        $search = mysqli_real_escape_string($connection, $search);


        $query = "SELECT posts.*, categories.title AS category_name, users.first_name, users.last_name, users.avatar 
                        FROM posts 
                        JOIN categories ON posts.category_id = categories.id 
                        JOIN users ON posts.author_id = users.id
                        WHERE posts.title LIKE '%$search%' OR 
                        posts.body LIKE '%$search%' OR 
                        users.first_name LIKE '%$search%' OR
                        users.last_name LIKE '%$search%'
                        ORDER BY posts.date_time DESC";


    
        $result = mysqli_query($connection, $query);

    } else {
        header('location: ' . ROOT_URL . 'blog.php');
        die();
    }

?>

<!--================== END OF HEADER =====================-->



    <!--=============== BEGINNING OF SECTION: POSTS =====================-->


    <!--=== CHECK IF RESULTS FOR THE SEARCHED TERM EXISTS ===-->
    <?php if(mysqli_num_rows($result)>0) : ?>
    <section class="posts  section__extra-margin" >
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


    <!--==== ERROR MESSAGE IF NO RESULT FOUND  ====-->
    <?php 
        else :
    ?>  
        <div class="alert__message error lg section__extra-margin">
            <p>
                <?= "No matching results found for the searched term: $search!" ?>
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
    <!--================== FOOTER END=====================-->
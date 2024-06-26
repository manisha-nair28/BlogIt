<!--================== HEADER =====================-->
<?php
    include 'partials/header.php';


    //fetch recent posts from DB
    $query = 'SELECT posts.*, categories.title AS category_name, users.first_name, users.last_name, users.avatar 
                        FROM posts 
                        JOIN categories ON posts.category_id = categories.id 
                        JOIN users ON posts.author_id = users.id 
                        ORDER BY posts.date_time DESC';

    $result = mysqli_query($connection, $query);
?>


    <!--=============== BEGINNING OF SEARCHBAR =====================-->

    <section class="search__bar">
        <form action="<?= ROOT_URL ?>search.php" class="container search__bar-container" method="GET">
            <div>
                <i class="uil uil-search"></i>
                <input type="search" name="search" placeholder="Search for articles...">
            </div>
            <button type="submit" name="submit" class="btn" >Go</button>
        </form>
    </section>

    <!--=============== END OF SEARCHBAR =====================-->


    <!--=============== BEGINNING OF SECTION: POSTS =====================-->

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
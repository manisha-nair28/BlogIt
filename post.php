<!--================== HEADER =====================-->
<?php
    include 'partials/header.php';

    //make sure an id is set otherwise redirect to blog.php 
    if(isset($_GET['id'])){
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

        //fetch the post from DB
        $query = "SELECT posts.*, categories.title AS category_name, users.first_name, users.last_name, users.avatar 
                FROM posts 
                JOIN categories ON posts.category_id = categories.id 
                JOIN users ON posts.author_id = users.id 
                WHERE posts.id = $id";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);

    } else {
        header('location: ' . ROOT_URL . 'blog.php');
        die();
    }
?>



   <!--=============== BEGINNING OF SINGLE POST =====================-->


    <section class="singlepost">
        <div class="container singlepost__container">
            <h2> 
                <?=$row['title']?>
            </h2>

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

            <div class="singlepost__thumbnail">
                <img src="./images/blog_images/<?=$row['thumbnail']?>" alt="blog-thumbnail">
            </div>

            <p>
                <?=$row['body']?> 
            </p>
           
        </div>
    </section>
    
    <!--================== END OF SINGLE POST =====================-->


     <!--================== FOOTER =====================-->
    <?php
        include 'partials/footer.php';
    ?>
<!--================== HEADER =====================-->
    <?php
        include 'partials/header.php';

        //fetch current user's post from DB
        $current_user_id = $_SESSION['user-id'];
        $query = "SELECT posts.id, posts.title, categories.title AS category_title 
          FROM posts 
          JOIN categories ON posts.category_id = categories.id 
          WHERE posts.author_id = $current_user_id 
          ORDER BY posts.id DESC";
        $result= mysqli_query($connection, $query);
    ?>



<section class="dashboard">



    <!--==== SUCCESS MESSAGE FOR USER BEING ADDED SUCCESSFULLY AND REDIRECTION TO THIS PAGE ====-->
    <?php
        if(isset($_SESSION['add-post-success'])) :
    ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['add-post-success']; 
                    unset($_SESSION['add-post-success']);
                ?>
            </p>
        </div>

    <!--==== SUCCESS MESSAGE FOR SUCCESSFULL POST UPDATE | EDIT  ====-->
    <?php
        elseif(isset($_SESSION['edit-post-success'])) :
    ?>
            <div class="alert__message success container">
                <p>
                    <?= $_SESSION['edit-post-success']; 
                        unset($_SESSION['edit-post-success']);
                    ?>
                </p>
            </div>

    <!--==== ERROR MESSAGE IF POST UPDATE | EDIT FAILS  ====-->
    <?php
        elseif(isset($_SESSION['edit-post'])) :
    ?>
            <div class="alert__message error container">
                <p>
                    <?= $_SESSION['edit-post']; 
                        unset($_SESSION['edit-post']);
                    ?>
                </p>
            </div>

     <!--==== SUCCESS MESSAGE FOR SUCCESSFULL POST DELETION ====-->
     <?php
        elseif(isset($_SESSION['delete-post-success'])) :
    ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['delete-post-success']; 
                    unset($_SESSION['delete-post-success']);
                ?>
            </p>
        </div>


    <!--==== ERROR MESSAGE IF DELETE POST FAILS  ====-->
    <?php
        elseif(isset($_SESSION['delete-post'])) :
    ?>
        <div class="alert__message error container">
            <p>
                <?= $_SESSION['delete-post']; 
                    unset($_SESSION['delete-post']);
                ?>
            </p>
        </div>

    <?php
        endif
    ?>


    <div class="container dashboard__container">
        <button id="show__sidebar-btn" class="sidebar__toggle">
            <i class="uil uil-angle-right-b"></i>
        </button>
        <button id="hide__sidebar-btn" class="sidebar__toggle">
            <i class="uil uil-angle-left-b"></i>
        </button>
        <aside>
            <ul>
                <li>
                    <a href="add-post.php">
                        <i class="uil uil-edit-alt"></i>
                        <h5>Add Post</h5>
                    </a>
                </li>

                <li>
                    <a href="index.php" class="active">
                        <i class="uil uil-create-dashboard"></i>
                        <h5>Manage Posts</h5>
                    </a>
                </li>

                <!--==== HIDING ADMIN OPTIONS FROM NORMAL USERS ====-->

                <?php if(isset($_SESSION['user_is_admin'])): ?>

                <li>
                    <a href="add-user.php">
                        <i class="uil uil-user-plus"></i>
                        <h5>Add User</h5>
                    </a>
                </li>

                <li>
                    <a href="manage-users.php" >
                        <i class="uil uil-users-alt"></i>
                        <h5>Manage Users</h5>
                    </a>
                </li>

                <li>
                    <a href="add-category.php">
                        <i class="uil uil-plus"></i>
                        <h5>Add Category</h5>
                    </a>
                </li>

                <li>
                    <a href="manage-categories.php" >
                        <i class="uil uil-clipboard-notes"></i>
                        <h5>Manage Categories</h5>
                    </a>
                </li>

                <?php endif ?>

            </ul>
        </aside>
        <main>
            <h2>Dashboard | Manage Posts</h2>

            <!--=== Check if no no posts are found ===-->
            <?php if(mysqli_num_rows($result)>0) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>

                <?php while($post = mysqli_fetch_assoc($result)): ?>
                    
                    <tr>
                        <td><?= $post['title'] ?></td>
                        <td><?= $post['category_title'] ?></td>
                        <td><a href="<?= ROOT_URL ?>admin/edit-post.php?id=<?= $post['id'] ?>" class="btn sm">Edit</a></td>
                        <td><a href="<?= ROOT_URL ?>admin/delete-post-logic.php?id=<?= $post['id'] ?>" class="btn sm danger">Delete</a></td>
                    </tr>

                <?php endwhile ?>  
                    
                </tbody>
            </table>

            <!--==== ERROR MESSAGE IF NO POST FOUND  ====-->
            <?php 
                else :
            ?>  
                <div class="alert__message error container">
                    <p>
                        <?="No posts found!"?>
                    </p>
                </div>
            <?php
                endif
            ?>
        </main>

    </div>
</section>

<!--================== FOOTER =====================-->
    <?php
        include '../partials/footer.php';
    ?>
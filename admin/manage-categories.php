<!--================== HEADER =====================-->
    <?php
        include 'partials/header.php';

        // fetch categories from DB
        $query = "SELECT * FROM categories ORDER BY title";
        $result = mysqli_query($connection, $query);
    ?>



<section class="dashboard">

    <!--==== SUCCESS MESSAGE FOR ON ADDING CATEGORY TO DB AND REDIRECTION TO THIS PAGE ====-->
    <?php
        if(isset($_SESSION['add-category-success'])) :
    ?>
        
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['add-category-success']; 
                    unset($_SESSION['add-category-success']);
                ?>
            </p>
        </div>

    <!--==== SUCCESS MESSAGE FOR SUCCESSFULL CATEGORY UPDATE | EDIT  ====-->
    <?php
        elseif(isset($_SESSION['edit-category-success'])) :
    ?>
            <div class="alert__message success container">
                <p>
                    <?= $_SESSION['edit-category-success']; 
                        unset($_SESSION['edit-category-success']);
                    ?>
                </p>
            </div>

    <!--==== ERROR MESSAGE IF CATEGORY UPDATE | EDIT FAILS  ====-->
    <?php
        elseif(isset($_SESSION['edit-category'])) :
    ?>
            <div class="alert__message error container">
                <p>
                    <?= $_SESSION['edit-category']; 
                        unset($_SESSION['edit-category']);
                    ?>
                </p>
            </div>

       
    <!--==== SUCCESS MESSAGE FOR SUCCESSFULL CATEGORY DELETION ====-->
    <?php
        elseif(isset($_SESSION['delete-category-success'])) :
    ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['delete-category-success']; 
                    unset($_SESSION['delete-category-success']);
                ?>
            </p>
        </div>


    <!--==== ERROR MESSAGE IF DELETE CATEGORY FAILS  ====-->
    <?php
        elseif(isset($_SESSION['delete-category'])) :
    ?>
        <div class="alert__message error container">
            <p>
                <?= $_SESSION['delete-category']; 
                    unset($_SESSION['delete-category']);
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
                    <a href="index.php">
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
                    <a href="manage-users.php">
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
                    <a href="manage-categories.php" class="active">
                        <i class="uil uil-clipboard-notes"></i>
                        <h5>Manage Categories</h5>
                    </a>
                </li>

                <?php endif ?>

            </ul>
        </aside>
        <main>
            <h2>Manage Categories</h2>

            <!--===== Check if no categories are found =====-->
            <?php if(mysqli_num_rows($result)>0) : ?>

            <table>

                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>

                <tbody>
                    <?php  while($row = mysqli_fetch_assoc($result)): ?>
                        
                        <tr>
                            <td><?= $row['title'] ?></td>
                            <td><a href="<?= ROOT_URL ?>admin/edit-category.php?id=<?= $row['id'] ?>" class="btn sm">Edit</a></td>
                            <td><a href="<?= ROOT_URL ?>admin/delete-category-logic.php?id=<?= $row['id'] ?>" class="btn sm danger">Delete</a></td>
                        </tr>
                    
                    <?php endwhile ?>  
                </tbody>
            </table>

            <!--==== ERROR MESSAGE IF NO CATEGORY FOUND  ====-->
            <?php 
                else :
            ?>  
                <div class="alert__message error container">
                    <p>
                        <?="No category found!"?>
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
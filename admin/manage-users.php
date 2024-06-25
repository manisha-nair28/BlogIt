<!--================== HEADER =====================-->
    <?php
        include 'partials/header.php';

        //fetch all users except the current user
        $current_admin_id = $_SESSION['user-id'];
        $query="SELECT * FROM users WHERE NOT id=$current_admin_id";
        $result= mysqli_query($connection, $query);
                               
    ?>


<section class="dashboard">

    <!--==== SUCCESS MESSAGE FOR USER BEING ADDED SUCCESSFULLY AND REDIRECTION TO THIS PAGE ====-->
    <?php
        if(isset($_SESSION['add-user-success'])) :
    ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['add-user-success']; 
                    unset($_SESSION['add-user-success']);
                ?>
            </p>
        </div>
 

    <!--==== SUCCESS MESSAGE FOR SUCCESSFULL USER UPDATE | EDIT  ====-->
    <?php
        elseif(isset($_SESSION['edit-user-success'])) :
    ?>
            <div class="alert__message success container">
                <p>
                    <?= $_SESSION['edit-user-success']; 
                        unset($_SESSION['edit-user-success']);
                    ?>
                </p>
            </div>

    <!--==== ERROR MESSAGE IF USER UPDATE | EDIT FAILS  ====-->
    <?php
        elseif(isset($_SESSION['edit-user'])) :
    ?>
            <div class="alert__message error container">
                <p>
                    <?= $_SESSION['edit-user']; 
                        unset($_SESSION['edit-user']);
                    ?>
                </p>
            </div>


    <!--==== SUCCESS MESSAGE FOR SUCCESSFULL USER DELETION ====-->
    <?php
        elseif(isset($_SESSION['delete-user-success'])) :
    ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['delete-user-success']; 
                    unset($_SESSION['delete-user-success']);
                ?>
            </p>
        </div>


    <!--==== ERROR MESSAGE IF DELETE USER FAILS  ====-->
    <?php
        elseif(isset($_SESSION['delete-user'])) :
    ?>
        <div class="alert__message error container">
            <p>
                <?= $_SESSION['delete-user']; 
                    unset($_SESSION['delete-user']);
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
                    <a href="manage-users.php" class="active">
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
            <h2>Manage Users</h2>
           
            <!--=== Check if no users are found except the current one ===-->
            <?php if(mysqli_num_rows($result)>0) : ?>

                <table>

                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            <th>Admin</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while($user = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?="{$user['first_name']}  {$user['last_name']}" ?></td>
                            <td><?= $user['username'] ?></td>
                            <td><a href="<?= ROOT_URL ?>admin/edit-user.php?id=<?= $user['id'] ?>" class="btn sm">Edit</a></td>
                            <td><a href="<?= ROOT_URL ?>admin/delete-user-logic.php?id= <?= $user['id'] ?>" class="btn sm danger">Delete</a></td>
                            <td>
                                <!-- 1 gives true; if 1 then yes/is admin else no -->
                                <?= $user['is_admin'] ? 'Yes' : 'No' ?>
                            </td>
                            </tr>
                        <?php endwhile ?>  
                    </tbody>

                </table>

            <!--==== ERROR MESSAGE IF NO USER FOUND  ====-->
            <?php 
                else :
            ?>  
                <div class="alert__message error container">
                    <p>
                        <?="No users found!"?>
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
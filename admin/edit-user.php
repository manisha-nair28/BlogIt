<!--================== HEADER =====================-->
    <?php
        include 'partials/header.php';

        if(isset($_GET['id'])){
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

            //fetch the details of user whose id is clicked
            $query = "SELECT * FROM users WHERE id=$id";
            $result = mysqli_query($connection, $query);
            $user = mysqli_fetch_assoc($result);

        } else {
            //without user id, this page cannot be accessed; redirect back
            header('location: ' . ROOT_URL . 'admin/manage-users.php');
            die();
        }
    ?>


<section class="form__section">
    <div class="container form__section-container">
        <h2>Edit User</h2>

        <form action="<?= ROOT_URL ?>admin/edit-user-logic.php" method="POST">

            <!-- hidden input field having the user id -->
            <input type="hidden" value="<?= $user['id'] ?>" name="id" >
            
            <input type="text" value="<?= $user['first_name'] ?>" name="firstname" placeholder="First Name">
            <input type="text" value="<?= $user['last_name'] ?>" name="lastname" placeholder="Last Name">
    
            <select name="userrole" >
                <option value="0" <?= !$user['is_admin'] ? 'selected' : '' ?>>Author</option>
                <option value="1" <?= $user['is_admin'] ? 'selected' : '' ?>>Admin</option>
            </select>
          
            <button type="submit" name="submit" class="btn">Update User</button>
           
        </form>

    
    </div>
</section>



<!--================== FOOTER =====================-->
    <?php
        include '../partials/footer.php';
    ?>
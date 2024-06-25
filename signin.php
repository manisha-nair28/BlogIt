<?php
    require 'config/constants.php';

    //get back form data in case of an error
    $username_email = $_SESSION['signin-data']['username_email'] ?? null;
    $password = $_SESSION['signin-data']['password'] ?? null;

    //delete return signup data session
    unset($_SESSION['signin-data']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Signin to BlogIt</title>
    <!-- Link to external custom CSS file -->
    <link rel="stylesheet" href="./css/style.css">
    <!-- iconscout CDN link -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <!-- Google Font: Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>


<body>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Sign In</h2>

        <!--==== SUCCESS MESSAGE FOR SUCESSFULL SIGN UP AND REDIRECTION TO THIS PAGE ====-->
        <?php
            if(isset($_SESSION['signup-success'])) :
        ?>
            <div class="alert__message success">
                <p>
                    <?= $_SESSION['signup-success']; 
                        unset($_SESSION['signup-success']);
                    ?>
                </p>
            </div>

            <!--==== ERROR MESSAGE FOR INVALID INPUT OR SIGN IN FAILURE ====-->
        <?php
            elseif(isset($_SESSION['signin'])) :
        ?>
            <div class="alert__message error">
                <p>
                    <?= $_SESSION['signin']; 
                        unset($_SESSION['signin']);
                    ?>
                </p>
            </div>
        <?php
            endif
        ?>

        
        <form action="<?= ROOT_URL ?>signin-logic.php" method="POST">
            <input type="text" name="username_email" value="<?= $username_email ?>" placeholder="Username or email">
            <input type="password" name="password" value="<?= $password ?>" placeholder="Password">
           
            <button type="submit" name="submit" class="btn">Sign In</button>
            <small>
                Don't have an account? 
                <a href="signup.php">Sign Up</a>
            </small>
        </form>
    </div>
</section>

</body>
</html>
<?php
    require './config/database.php';

    // fetch current user avatar from DB
    if(isset($_SESSION['user-id'])){

        // Sanitizing 
        $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);

        // Escaping
        $id = mysqli_real_escape_string($connection, $id);

        $query = "SELECT avatar FROM users WHERE id=$id";
        $result = mysqli_query($connection, $query);
        $avatar = mysqli_fetch_assoc($result);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BlogIt</title>
    <!-- Link to external custom CSS file -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css">
    <!-- iconscout CDN link -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <!-- Google Font: Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>


<body>

     <!--=============== BEGINNING OF NAVBAR =====================-->
   <nav>
        <div class="container nav__container">
            <a href="<?= ROOT_URL ?>" class="nav__logo">BlogIt!</a>
            <ul class="nav__items">
                <li><a href="<?= ROOT_URL ?>blog.php" class="nav__menu-link">Blog</a></li>
                <li><a href="<?= ROOT_URL ?>about.php" class="nav__menu-link">About</a></li>
                <li><a href="<?= ROOT_URL ?>services.php" class="nav__menu-link">Services</a></li>
                <li><a href="<?= ROOT_URL ?>contact.php" class="nav__menu-link">Contact</a></li>
               
            
            <?php if(isset($_SESSION['user-id'])): ?>

                <!-- profile image; hide it if not signed in -->
                <li class="nav__profile">
                    <div class="avatar">
                        <img src="<?= ROOT_URL . 'images/avatar/' . $avatar['avatar'] ?>" alt="avatar">
                    </div>
                    <ul>
                        <li><a href="<?= ROOT_URL ?>admin/index.php">Dashboard</a></li>
                        <li><a href="<?= ROOT_URL ?>logout.php">Logout</a></li>
                    </ul>
                </li>

            <?php else: ?>

                <!-- sign in option; hide if signed in and display pfp -->
                <li><a href="<?= ROOT_URL ?>signin.php" class="nav__menu-link">Signin</a></li>
                
            <?php endif ?>
                
                
            </ul>

            <button id="open__nav-btn"><i class="uil uil-list-ul"></i></button>
            <button id="close__nav-btn"><i class="uil uil-times-circle"></i></button>

        </div>
   </nav>
   <!--=============== END OF NAVBAR =====================-->

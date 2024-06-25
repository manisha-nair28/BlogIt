<?php
    require '../partials/header.php';

    //check login status (if clicked after logging out, admin/profile dashboard pages should not be accessible)
    if(!isset($_SESSION['user-id'])){
        header('location: ' . ROOT_URL . 'signin.php');
        die();
    }
   
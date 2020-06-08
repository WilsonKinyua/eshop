<?php

    ob_start();
    session_start();

    session_destroy();

    if(isset($_COOKIE['email'])) {

        unset($_COOKIE['email']);
        unset($_SESSION['username']);
        $_SESSION['username'] = null;
        $_SESSION['first_name'] = null;
        $_SESSION['last_name'] = null;
        setcookie("email","",time() - 86400);

    }



    header("Location: index.php");



?>

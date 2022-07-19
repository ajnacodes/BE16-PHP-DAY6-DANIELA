<?php
    session_start();
    if(!isset($_SESSION["user"]) && !isset($_SESSION["admin"])){
        header("Location: index.php");
        exit;
    }elseif(isset($_SESSION["user"])){
        header("Location: home.php");
    }elseif(isset($_SESSION["admin"])){
        header("Location: dashboard.php");
    }

    if(isset($_GET["logout"])){
        unset($_SESSION["user"]);
        unset($_SESSION["admin"]);
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit;
    }
?>
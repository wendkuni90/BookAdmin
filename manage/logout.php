<?php require "../includes/admin_session.php" ?>
<?php 

    if(!isset($_SESSION['ad_name'])){
        header("location: ../auth/login_admin.php");
        exit();
    } else {
        session_start();
        session_unset();
        session_destroy();

        header("location: ../");
        exit();
    }

?>
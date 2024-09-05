<?php require "../includes/librarian_session.php" ?>
<?php 

    if(!isset($_SESSION['lib_id'])){
        header("location: ../auth/login_biblio.php");
        exit();
    } else {
        session_start();
        session_unset();
        session_destroy();

        header("location: ../");
        exit();
    }

?>
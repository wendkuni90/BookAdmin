<?php require "../../../includes/librarian_session.php" ?>
<?php require "../../../config/config.php" ?>
<?php

    if(!isset($_SESSION['lib_id'])){
        header("location: ../../../auth/login_biblio.php");
        exit();
    }

    if(isset($_POST['save'])){
        $new_name = htmlspecialchars($_POST['name']);
        $librarian_id = $_SESSION['lib_id'];

        $sql = "UPDATE librarian SET librarian_name = :name WHERE librarian_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $new_name);
        $stmt->bindParam(':id', $librarian_id, PDO::PARAM_INT);
        
        if($stmt->execute()){
            header("location: ../../setting.php");
        } else {
            echo "Erreur lors de la mise à jour";
        }
    }

?>
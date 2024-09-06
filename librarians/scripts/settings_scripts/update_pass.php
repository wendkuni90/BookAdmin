<?php require "../../../includes/librarian_session.php" ?>
<?php require "../../../config/config.php" ?>

<?php

    if(!isset($_SESSION['lib_id'])){
        header("location: ../../../auth/login_biblio.php");
        exit();
    }

    if(isset($_POST['change'])){
        $librarian_id = $_SESSION['lib_id'];
		$oldpass = $_POST['oldpass'];
		$newpass = $_POST['newpass'];
		$conpass = $_POST['conpass'];

        //Verifier si le oldpass saisi correspond au mot de passe courant du bibliothécaire
        $sql = "SELECT librarian_pass FROM librarian WHERE librarian_id = :id";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':id', $librarian_id, PDO::PARAM_INT);
		$stmt->execute();
		$librarian = $stmt->fetch(PDO::FETCH_ASSOC);

        if($librarian && password_verify($oldpass, $librarian['librarian_pass'])){
            //Verifions que les deux mdp sont identiques
            if($newpass === $conpass){
                //Hachons et enregistrons les modifs
                $hashed_pass = password_hash($newpass, PASSWORD_DEFAULT);
                $update = "UPDATE librarian SET librarian_pass = :password WHERE librarian_id = :id";
                $up_stmt = $conn->prepare($update);
                $up_stmt->bindParam(':password', $hashed_pass);
                $up_stmt->bindParam(':id', $librarian_id, PDO::PARAM_INT);

                if($up_stmt->execute()){
                    session_start();
                    session_unset();
                    session_destroy();
                    header("location: ../../../auth/login_biblio.php");
                    exit();
                }
            } else {
                header("location: ../../setting.php");
                exit();
            }
        } else {
            header("location: ../../setting.php");
            exit();
        }
    }

?>
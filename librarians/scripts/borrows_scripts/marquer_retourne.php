<?php require "../../../includes/librarian_session.php" ?>
<?php require "../../../config/config.php" ?>

<?php

    if(!isset($_SESSION['lib_id'])){
        header("location: ../../../auth/login_biblio.php");
        exit();
    }

    if(isset($_GET['id'])){
        $borrow_id = $_GET['id'];

        //Mettre à jour le statut de l'emprunt
        $stmt = $conn->prepare("UPDATE borrow SET borrow_status = 'Retourné', borrow_return = CURDATE() WHERE borrow_id = ?");
        $stmt->execute([$borrow_id]);

        //Récupérer le book_id
        $stmt = $conn->prepare("SELECT book_id FROM borrow WHERE borrow_id = ?");
        $stmt->execute([$borrow_id]);
        $book_id = $stmt->fetchColumn();

        //Incréménter le nbre d'exemplaires du livre concerné
        $stmt = $conn->prepare("UPDATE book SET book_copies = book_copies+1 WHERE book_id = ?");
        $stmt->execute([$book_id]);

        //Rediriger vers la page des emprunts
        header("location: ../../borrowings.php");
        exit();
    } else {
        header("location: ../../borrowings.php");
        exit();
    }

?>
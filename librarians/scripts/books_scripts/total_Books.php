<?php

    if(!isset($_SESSION['lib_id'])){
        header("location: ../../../auth/login_biblio.php");
        exit();
    }
    $librarian_id = $_SESSION['lib_id'];
    $sql = "SELECT b.book_id, b.book_quote, b.book_title, b.book_auth, b.book_copies
            FROM book b
            JOIN librarian l ON (l.library_id = b.library_id)
            WHERE librarian_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $librarian_id, PDO::PARAM_INT);
    $stmt->execute();

    //Récupération de la liste
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
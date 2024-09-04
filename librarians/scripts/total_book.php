<?php

    if(!isset($_SESSION['lib_id'])){
        header("location: ../../auth/login_biblio.php");
        exit();
    }

    //Nombre total des livres se trouvant dans la mm bibliothque qu'un bibliothécaire
    $librarian_id = $_SESSION['lib_id'];
    $sql = "SELECT COUNT(b.book_id) AS book_count
            FROM librarian l
            INNER JOIN library lib ON l.library_id = lib.library_id
            INNER JOIN book b ON lib.library_id = b.library_id
            WHERE l.librarian_id = :librarian_id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':librarian_id', $librarian_id, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_book = $row['book_count'];
?>
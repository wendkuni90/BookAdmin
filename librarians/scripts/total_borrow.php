<?php

    if(!isset($_SESSION['lib_id'])){
        header("location: ../../auth/login_biblio.php");
        exit();
    }

    //Nombre total des emprunts se trouvant dans la mm bibliothque qu'un bibliothécaire
    $librarian_id = $_SESSION['lib_id'];
    $sql = "SELECT COUNT(br.borrow_id) AS borrow_count
            FROM librarian l
            INNER JOIN library lib ON l.library_id = lib.library_id
            INNER JOIN book b ON lib.library_id = b.library_id
            INNER JOIN borrow br ON b.book_id = br.book_id
            WHERE l.librarian_id = :librarian_id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':librarian_id', $librarian_id, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_borrow = $row['borrow_count'];
?>
<?php

    if(!isset($_SESSION['lib_id'])){
        header("location: ../../../auth/login_biblio.php");
        exit();
    }
    $librarian_id = $_SESSION['lib_id'];
    $sql = "SELECT br.borrow_id, s.student_name, b.book_title, br.borrow_date, br.borrow_return, br.borrow_status
            FROM borrow br
            JOIN student s ON (s.student_id = br.student_id)
            JOIN book b ON (b.book_id = br.book_id)
            JOIN librarian l ON (l.librarian_id = br.librarian_id)
            WHERE l.librarian_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $librarian_id, PDO::PARAM_INT);
    $stmt->execute();

    //Récupération de la liste
    $borrows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
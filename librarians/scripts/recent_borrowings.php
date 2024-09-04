<?php

    if(!isset($_SESSION['lib_id'])){
        header("location: ../../auth/login_biblio.php");
        exit();
    }

    $librarian_id = $_SESSION['lib_id'];
    $sql = "SELECT b.book_title, s.student_name, br.borrow_status, br.borrow_date
            FROM borrow br
            JOIN student s ON (br.student_id = s.student_id)
            JOIN book b ON (br.book_id = b.book_id)
            JOIN librarian l ON (s.library_id = l.library_id)
            WHERE l.librarian_id = :librarian_id
            AND br.borrow_status = 'En cours'
            ORDER BY br.borrow_date DESC
            LIMIT 10";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':librarian_id', $librarian_id, PDO::PARAM_INT);
    $stmt->execute();

    $recent_borrows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
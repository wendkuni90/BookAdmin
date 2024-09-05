<?php

    if(!isset($_SESSION['lib_id'])){
        header("location: ../../auth/login_biblio.php");
        exit();
    }

    $librarian_id = $_SESSION['lib_id'];

    $sql = "SELECT s.student_name, bk.book_title, b.borrow_status, b.borrow_date
            FROM borrow b
            JOIN librarian l ON b.librarian_id = l.librarian_id
            JOIN student s ON b.student_id = s.student_id
            JOIN book bk ON b.book_id = bk.book_id
            WHERE l.librarian_id = :librarian_id
            AND b.borrow_status = 'En cours'
            ORDER BY b.borrow_date DESC
            LIMIT 10";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':librarian_id', $librarian_id, PDO::PARAM_INT);
    $stmt->execute();

    $recent_borrows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
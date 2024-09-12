<?php

    if(!isset($_SESSION['lib_id'])){
        header("location: ../../auth/login_biblio.php");
        exit();
    }

    $id = $_SESSION['lib_id'];
    $research = $conn->prepare("SELECT * FROM librarian WHERE librarian_id = '$id'");
    $research->execute();
    $librarian = $research->fetch(PDO::FETCH_ASSOC);
    $library_id = $librarian['library_id'];

    $sql = "SELECT s.student_name, bk.book_title, b.borrow_status, b.borrow_date
            FROM borrow b
            JOIN student s ON b.student_id = s.student_id
            JOIN book bk ON b.book_id = bk.book_id
            JOIN library l ON l.library_id = bk.library_id
            WHERE l.library_id = :library_id
            AND b.borrow_status = 'En cours'
            ORDER BY b.borrow_date DESC
            LIMIT 10";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':library_id', $library_id, PDO::PARAM_INT);
    $stmt->execute();

    $recent_borrows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
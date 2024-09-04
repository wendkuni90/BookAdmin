<?php

    if(!isset($_SESSION['lib_id'])){
        header("location: ../../auth/login_biblio.php");
        exit();
    }

    $librarian_id = $_SESSION['lib_id'];
    $sql = "SELECT s.student_id, s.student_ine, s.student_name, s.student_mail, s.creation_date
            FROM librarian l
            INNER JOIN student s ON l.library_id = s.library_id
            WHERE l.librarian_id = :librarian_id
            AND s.creation_date >= DATE_SUB(CURDATE(), INTERVAL 5 DAY)
            ORDER BY s.creation_date DESC
            LIMIT 10";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':librarian_id', $librarian_id, PDO::PARAM_INT);
    $stmt->execute();

    $recent_students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
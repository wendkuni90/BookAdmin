<?php

    if(!isset($_SESSION['lib_id'])){
        header("location: ../../../auth/login_biblio.php");
        exit();
    }
    $librarian_id = $_SESSION['lib_id'];
    $sql = "SELECT s.student_id, s.student_ine, s.student_name, s.student_mail
            FROM student s
            JOIN librarian l ON (l.library_id = s.library_id)
            WHERE librarian_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $librarian_id, PDO::PARAM_INT);
    $stmt->execute();

    //Récupération de la liste
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
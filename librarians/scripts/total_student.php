<?php

    if(!isset($_SESSION['lib_id'])){
        header("location: ../../auth/login_biblio.php");
        exit();
    }

    //Nombre total des etudiants se trouvant dans la mm bibliothque qu'un bibliothécaire
    $librarian_id = $_SESSION['lib_id'];
    $sql = "SELECT COUNT(s.student_id) AS student_count
            FROM librarian l
            INNER JOIN student s ON s.library_id = l.library_id
            WHERE l.librarian_id = :librarian_id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':librarian_id', $librarian_id, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_student = $row['student_count'];
?>
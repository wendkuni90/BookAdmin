<?php

    if(!isset($_SESSION['lib_id'])){
        header("location: ../../auth/login_biblio.php");
        exit();
    }

    //Nombre de librarians dans la mm bibliothèque que lui
    $librarian_id = $_SESSION['lib_id'];
    $sql = "SELECT COUNT(l2.librarian_id) AS librarian_count
            FROM librarian l1
            INNER JOIN librarian l2 ON l1.library_id = l2.library_id
            WHERE l1.librarian_id = :librarian_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':librarian_id', $librarian_id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $total_librarian = $row['librarian_count'];

?>
<?php 

	if(!isset($_SESSION['ad_id'])){
		header("location: ../../../auth/login_admin.php");
        exit();
	}

	$sql = "SELECT l.library_id, l.library_name, COUNT(DISTINCT lb.librarian_id) AS total_librarians,
            COUNT(DISTINCT b.book_id) AS total_books, COUNT(DISTINCT s.student_id) AS total_students
            FROM library l
            LEFT JOIN librarian lb ON (l.library_id = lb.library_id)
            LEFT JOIN book b ON (l.library_id = b.library_id)
            LEFT JOIN student s ON (l.library_id = s.library_id)
            GROUP BY l.library_id, l.library_name";
	$stmt = $conn->prepare($sql);
	$stmt->execute();

    //Récupération des résultats
    $libraries = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
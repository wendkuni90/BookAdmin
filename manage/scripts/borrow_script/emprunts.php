<?php 

	if(!isset($_SESSION['ad_name'])){
		header("location: ../../../auth/login_admin.php");
        exit();
	}

	$sql = "SELECT b.book_title, s.student_name, br.borrow_status, br.borrow_date, br.borrow_return
            FROM borrow br
            JOIN student s ON (br.student_id = s.student_id)
            JOIN book b ON (br.book_id = b.book_id)
            ORDER BY br.borrow_date DESC";
	$stmt = $conn->prepare($sql);
	$stmt->execute();

    //Récupération des résultats
    $borrows = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
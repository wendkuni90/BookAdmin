<?php 

	if(!isset($_SESSION['ad_id'])){
		header("location: ../../auth/login_admin.php");
        exit();
	}

	$sql = "SELECT b.book_title, s.student_name, br.borrow_status, br.borrow_date
            FROM borrow br
            JOIN student s ON (br.student_id = s.student_id)
            JOIN book b ON (br.book_id = b.book_id)
            WHERE br.borrow_status = 'En cours'
            ORDER BY br.borrow_date DESC
            LIMIT 10";
	$stmt = $conn->prepare($sql);
	$stmt->execute();

    //Récupération des résultats
    $borrows = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
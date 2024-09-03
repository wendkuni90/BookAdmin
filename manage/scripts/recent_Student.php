<?php 

	if(!isset($_SESSION['ad_id'])){
		header("location: ../../auth/login_admin.php");
        exit();
	}

	$sql = "SELECT student_ine, student_name, student_mail
            FROM student
            WHERE creation_date >= DATE_SUB(NOW(), INTERVAL 5 DAY)
            ORDER BY creation_date DESC
            LIMIT 10";
	$stmt = $conn->prepare($sql);
	$stmt->execute();

    //Récupération des résultats
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
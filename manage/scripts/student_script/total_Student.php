<?php 

	if(!isset($_SESSION['ad_id'])){
		header("location: ../../../auth/login_admin.php");
		exit();
	}

	$sql = "SELECT *
            FROM student
            ORDER BY creation_date DESC";
	$stmt = $conn->prepare($sql);
	$stmt->execute();

    //Récupération des résultats
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
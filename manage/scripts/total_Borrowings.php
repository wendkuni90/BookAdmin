<?php 

	if(!isset($_SESSION['ad_id'])){
		header("location: ../../auth/login_admin.php");
		exit();
	}

	//Nombre total des Bibliothécaires
	$sql = "SELECT COUNT(*) AS total_borrow FROM borrow";
	$stmt = $conn->prepare($sql);
	$stmt->execute();

	//Récupération du nombre total
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$totalEmprunts = $row['total_borrow'];

?>
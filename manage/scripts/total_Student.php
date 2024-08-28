<?php 

	if(!isset($_SESSION['ad_name'])){
		header("location: ../../auth/login_admin.php");
	}

	//Nombre total des Etudiants de toutes les bibliothèques
	$sql = "SELECT COUNT(*) AS total_students FROM student";
	$stmt = $conn->prepare($sql);
	$stmt->execute();

	//Récupération du nombre total
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$totalEtudiant = $row['total_students'];

?>
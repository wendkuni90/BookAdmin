<?php 

	if(!isset($_SESSION['ad_name'])){
		header("location: ../../auth/login_admin.php");
	}

	//Nombre total de Livres de toutes les bibliothèques
	$sql = "SELECT COUNT(*) AS total_book FROM book";
	$stmt = $conn->prepare($sql);
	$stmt->execute();

	//Récupération du nombre total
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$totalBook = $row['total_book'];

?>
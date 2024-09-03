<?php 

	if(!isset($_SESSION['ad_id'])){
		header("location: ../../auth/login_admin.php");
		exit();
	}

	//Nombre total de Livres de toutes les bibliothèques
	$sql = "SELECT COUNT(*) AS total_book FROM book";
	$stmt = $conn->prepare($sql);
	$stmt->execute();

	//Récupération du nombre total
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$totalBook = $row['total_book'];

?>
<?php 

	if(!isset($_SESSION['ad_id'])){
		header("location: ../../auth/login_admin.php");
		exit();
	}

	//Nombre total des Bibliothécaires
	$sql = "SELECT COUNT(*) AS total_librarian FROM librarian";
	$stmt = $conn->prepare($sql);
	$stmt->execute();

	//Récupération du nombre total
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$totalLibrarian = $row['total_librarian'];

?>
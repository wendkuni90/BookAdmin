<?php 

	if(!isset($_SESSION['ad_name'])){
		header("location: ../../../auth/login_admin.php");
		exit();
	}

	$sql = "SELECT *
            FROM book
            ORDER BY book_title";
	$stmt = $conn->prepare($sql);
	$stmt->execute();

    //Récupération des résultats
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
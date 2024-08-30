<?php 

	if(!isset($_SESSION['ad_name'])){
		header("location: ../../../auth/login_admin.php");
	}

	$sql = "SELECT lb.librarian_id, lb.librarian_name, l.library_name, lb.librarian_tel, lb.librarian_mail
            FROM librarian lb
            JOIN library l ON (lb.library_id = l.library_id)";
	$stmt = $conn->prepare($sql);
	$stmt->execute();

    //Récupération des résultats
    $librarians = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<?php require "../includes/admin_session.php" ?>
<?php require "../config/config.php" ?>
<?php 

	if(!isset($_SESSION['ad_name'])){
		header("location: ../auth/login_admin.php");
	}

?>

Page pour la liste de tous les emprunts en cours de toutes les bibliotheques
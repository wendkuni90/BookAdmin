<?php require "../includes/admin_session.php" ?>
<?php require "../config/config.php" ?>
<?php 

	if(!isset($_SESSION['ad_name'])){
		header("location: ../auth/login_admin.php");
	}

?>

Page de gestion du compte de l'administrateur
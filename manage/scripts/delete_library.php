<?php require "../../includes/admin_session.php" ?>
<?php require "../../config/config.php" ?>
<?php 

	if(!isset($_SESSION['ad_name'])){
		header("location: ../../auth/login_admin.php");
        exit();
	}

    if(isset($_GET['id'])) {
        $library_id = $_GET['id'];
        $sql = "DELETE FROM library WHERE library_id = :library_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':library_id', $library_id, PDO::PARAM_INT);
        $stmt->execute();
        header("Location: ../library.php");
        exit();
    } else {
        header("Location: ../library.php");
        exit();
    }

?>
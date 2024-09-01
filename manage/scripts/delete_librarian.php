<?php require "../../includes/admin_session.php" ?>
<?php require "../../config/config.php" ?>
<?php 

	if(!isset($_SESSION['ad_name'])){
		header("location: ../../auth/login_admin.php");
        exit();
	}

    if(isset($_GET['id'])) {
        $librarian_id = $_GET['id'];
        $sql = "DELETE FROM librarian WHERE librarian_id = :librarian_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':librarian_id', $librarian_id, PDO::PARAM_INT);
        $stmt->execute();
        header("Location: ../librarian.php");
        exit();
    } else {
        header("Location: ../librarian.php");
        exit();
    }

?>
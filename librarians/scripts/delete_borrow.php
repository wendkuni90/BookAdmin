<?php require "../../includes/librarian_session.php" ?>
<?php require "../../config/config.php" ?>
<?php 

	if(!isset($_SESSION['lib_id'])){
		header("location: ../../auth/login_biblio.php");
        exit();
	}

    if(isset($_GET['id'])) {
        $borrow_id = $_GET['id'];
        $sql = "DELETE FROM borrow WHERE borrow_id = :borrow_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':borrow_id', $borrow_id, PDO::PARAM_INT);
        $stmt->execute();
        header("Location: ../borrowings.php");
        exit();
    } else {
        header("Location: ../borrowings.php");
        exit();
    }

?>
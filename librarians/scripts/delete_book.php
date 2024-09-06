<?php require "../../includes/librarian_session.php" ?>
<?php require "../../config/config.php" ?>
<?php 

	if(!isset($_SESSION['lib_id'])){
		header("location: ../../auth/login_biblio.php");
        exit();
	}

    if(isset($_GET['id'])) {
        $book_id = $_GET['id'];
        $sql = "DELETE FROM book WHERE book_id = :book_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
        $stmt->execute();
        header("Location: ../books.php");
        exit();
    } else {
        header("Location: ../books.php");
        exit();
    }

?>
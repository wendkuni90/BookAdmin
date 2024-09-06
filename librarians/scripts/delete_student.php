<?php require "../../includes/librarian_session.php" ?>
<?php require "../../config/config.php" ?>
<?php 

	if(!isset($_SESSION['lib_id'])){
		header("location: ../../auth/login_biblio.php");
        exit();
	}

    if(isset($_GET['id'])) {
        $student_id = $_GET['id'];
        $sql = "DELETE FROM student WHERE student_id = :student_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->execute();
        header("Location: ../students.php");
        exit();
    } else {
        header("Location: ../students.php");
        exit();
    }

?>
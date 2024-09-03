<?php require "../../../includes/admin_session.php" ?>
<?php require "../../../config/config.php" ?>
<?php 

	if(!isset($_SESSION['ad_id'])){
		header("location: ../../../auth/login_admin.php");
		exit();
	}

    if(isset($_POST['save'])){
        $new_name = htmlspecialchars($_POST['name']);
        $new_mail = $_POST['mail'];
        $admin_id = $_SESSION['ad_id'];

        $sql = "UPDATE admin SET admin_name = :name, admin_mail = :mail WHERE admin_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $new_name);
        $stmt->bindParam(':mail', $new_mail);
        $stmt->bindParam(':id', $admin_id, PDO::PARAM_INT);
        
        if($stmt->execute()){
            $_SESSION['ad_name'] = $new_name;
            header("location: ../../setting.php");
        } else {
            echo "Erreur lors de la mise à jour";
        }
    }

?>

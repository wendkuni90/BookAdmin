<?php require "../../../includes/admin_session.php" ?>
<?php require "../../../config/config.php" ?>
<?php 

	if(!isset($_SESSION['ad_name'])){
		header("location: ../../../auth/login_admin.php");
		exit();
	}

    if(isset($_POST['change'])){
		$admin_id = $_SESSION['ad_id'];
		$oldpass = $_POST['oldpass'];
		$newpass = $_POST['newpass'];
		$conpass = $_POST['conpass'];

		//Je vais vérifier si le oldpass saisi correspond au mot de pass de l'administrateur
		$sql = "SELECT admin_pass FROM admin WHERE admin_id = :id";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':id', $admin_id, PDO::PARAM_INT);
		$stmt->execute();
		$admin = $stmt->fetch(PDO::FETCH_ASSOC);

		if($admin && password_verify($oldpass,$admin['admin_pass'])){
			//Confirmons que le nouveau mdp est bien celui entré dans la confirmation
			if($newpass === $conpass){
				//On hache et on enregistre les modifications
				$hashed_pass = password_hash($newpass, PASSWORD_DEFAULT);
				$update = "UPDATE admin SET admin_pass = :password WHERE admin_id = :id";
				$up_stmt = $conn->prepare($update);
				$up_stmt->bindParam(':password', $hashed_pass);
				$up_stmt->bindParam(':id', $admin_id, PDO::PARAM_INT);
				
				if($up_stmt->execute()){
					session_start();
					session_unset();
					session_destroy();
					header("location: ../../../auth/login_admin.php");
					exit();
				}
			} else {
				header("location: ../../setting.php");
				exit();
			}

		} else {
			header("location: ../../setting.php");
			exit();
		}

    }

?>

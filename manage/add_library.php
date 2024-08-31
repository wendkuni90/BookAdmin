<?php require "../includes/admin_session.php" ?>
<?php require "../config/config.php" ?>
<?php 

	if(!isset($_SESSION['ad_name'])){
		header("location: ../auth/login_admin.php");
	}

	$sql1 = "SELECT l.library_id, l.library_name
			FROM library l";
	$stmt1 = $conn->prepare($sql1);
	$stmt1->execute();
	$libraries = $stmt1->fetchAll(PDO::FETCH_ASSOC);

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$library_name = htmlspecialchars($_POST['library_name']);

   		// Je vérifie si la bibliothèque existe déjà
		$sql_check = "SELECT COUNT(*) FROM library WHERE library_name = :name";
		$stmt_check = $conn->prepare($sql_check);
		$stmt_check->bindParam(':name', $library_name);
		$stmt_check->execute();
		$exists = $stmt_check->fetchColumn();
		if ($exists) {
			$error_message = "Ajout refusé: Données incorrectes.";
		} else {
			// Insertion de la nouvelle bibliothèque
			$sql = "INSERT INTO library (library_name) VALUES (:name)";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':name', $library_name);
			$stmt->execute();
			header("Location: library.php");
			exit();
		}
	}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ajouter Bibliothèque</title>
	<link rel="stylesheet" href="../assets/css/librarian.css">
	<style>
		.error {
			color: #ff0c04;
			background-color: #f8d7da;
			border: 1px solid #ff0800;
			border-radius: 5px; 
			padding: 5px;
			margin-bottom: 10px;
			display: flex;
			font-weight: bold;
			align-items: center;
		}

		.error::before {
			content: "⚠️";
			font-size: 18px;
			margin-right: 10px; 
		}
	</style>
	<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<div class="sidebar">
		<div class="logo_details">
			<i class='bx bx-book-open'></i>
			<div class="logo_name">
				BookTrack
			</div>
		</div>
		<ul>
			<li>
				<a href="admin_dash.php">
				<i class='bx bx-grid-alt'></i>
				<span class="links_name">
					Tableau de bord
				</span>
				</a>
			</li>
			<li>
				<a href="librarian.php">
				<i class='bx bx-user'></i>
				<span class="links_name">
					Bibliothécaires
				</span>
				</a>
			</li>
			<li>
				<a href="library.php">
				<i class='bx bx-book-open'></i>
				<span class="links_name">
					Bibliothèques
				</span>
				</a>
			</li>
			<li>
				<a href="student.php">
				<i class='bx bx-user'></i>
				<span class="links_name">
					Etudiants
				</span>
				</a>
			</li>
			<li>
				<a href="book.php">
				<i class='bx bx-book' ></i>
				<span class="links_name">
					Livres
				</span>
				</a>
			</li>
			<li>
				<a href="borrow.php">
				<i class='bx bxs-cart'></i>
				<span class="links_name">
					Emprunts
				</span>
				</a>
			</li>
			<li>
				<a href="add_library.php" class="active">
				<i class='bx bxs-book'></i>
				<span class="links_name">
					Ajouter Bibliothèque
				</span>
				</a>
			</li>
			<li>
				<a href="add_librarian.php">
				<i class='bx bxs-user-plus'></i>
				<span class="links_name">
					Ajouter Bibliothécaire
				</span>
				</a>
			</li>
			<li>
				<a href="setting.php">
				<i class='bx bx-cog'></i>
				<span class="links_name">
					Paramètres
				</span>
				</a>
			</li>
			<li class="login">
				<a href="logout.php">
				<span class="links_name login_out">
					Se déconnecter
				</span>
				<i class='bx bx-log-out' id="log_out"></i>
				</a>
			</li>
		</ul>
	</div>

	<section class="home_section">
		<div class="topbar">
			<div class="toggle">
				<i class='bx bx-menu' id="btn"></i>
			</div>
			
			<div class="user_wrapper">
				<!-- <img src="img/user.jpg" alt=""> -->
				<p>Bienvenue</p>
				<?php if(isset($_SESSION['ad_name'])): ?>
                    <h2 style="text-transform: capitalize; font-size:20px;">
                    	<?php echo $_SESSION['ad_name']; ?>
                    </h2>
                <?php endif; ?>
			</div>
		</div>

		<div class="details">
			<div class="recent_project">
				<h2 style="margin-bottom:20px;">Ajout de bibliothèque</h2>
				<form method="post">
					<div>
						<label for="name">Nom</label>
						<input type="text" name="library_name" id="name" style="text-transform:uppercase;" required>
					</div>

					<?php if (!empty($error_message)): ?>
                    	<p class="error"><?= htmlspecialchars($error_message) ?></p>
                	<?php endif; ?>

					<div>
						<input type="submit" name="add" value="Ajouter">
					</div>
				</form>
			</div>
		</div>
	</section>

	<script src="../assets/js/dash.js"></script>
</body>
</html>
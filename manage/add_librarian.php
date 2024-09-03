<?php require "../includes/admin_session.php" ?>
<?php require "../config/config.php" ?>
<?php 

	if(!isset($_SESSION['ad_name'])){
		header("location: ../auth/login_admin.php");
		exit();
	}

	$sql1 = "SELECT l.library_id, l.library_name
			FROM library l";
	$stmt1 = $conn->prepare($sql1);
	$stmt1->execute();
	$libraries = $stmt1->fetchAll(PDO::FETCH_ASSOC);

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$default_pass = 'test';
		$hashed = password_hash($default_pass,PASSWORD_DEFAULT);
		$librarian_name = htmlspecialchars($_POST['librarian_name']);
		$librarian_mail = htmlspecialchars($_POST['librarian_mail']);
		$librarian_tel = htmlspecialchars($_POST['librarian_tel']);
		$library_id = $_POST['library_id'];

		$sql = "INSERT INTO librarian (librarian_name, librarian_mail, librarian_tel, library_id, librarian_pass)
				VALUES (:name, :mail, :tel, :library, :pass)";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':name', $librarian_name);
        $stmt->bindParam(':mail', $librarian_mail);
        $stmt->bindParam(':tel', $librarian_tel);
        $stmt->bindParam(':library', $library_id);
		$stmt->bindParam(':pass', $hashed);
		$stmt->execute();
		header("location: librarian.php");
		exit();
	}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ajouter Bibliothécaire</title>
	<link rel="stylesheet" href="../assets/css/libra.css?v=1.0">
	<link rel="stylesheet" href="../assets/css/add_lib.css?v=1.0">
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
				<a href="add_library.php">
				<i class='bx bxs-book'></i>
				<span class="links_name">
					Ajouter Bibliothèque
				</span>
				</a>
			</li>
			<li>
				<a href="add_librarian.php" class="active">
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
				<h2 style="margin-bottom:20px;">Ajout de bibliothécaire</h2>
				<form method="post">
					<div>
						<input type="text" name="librarian_name" id="name" placeholder="Nom Complet" style="text-transform:uppercase;" required>
					</div>
					<div>
						<input type="text" name="librarian_mail" id="mail" placeholder="Email" style="text-transform:lowercase;">
					</div>
					<div>
						<input type="text" name="librarian_tel" id="tel" placeholder="Numéro(+xxx xx...)" required>
					</div>
					<div>
						<select name="library_id" id="library" required style="text-transform:uppercase;">
							<?php foreach ($libraries as $library): ?>
								<option value="<?= $library['library_id']; ?>"> <?= $library['library_name']; ?> </option>
							<?php endforeach; ?>
                    	</select>
					</div>
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
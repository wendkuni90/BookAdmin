<?php require "../../includes/admin_session.php" ?>
<?php require "../../config/config.php" ?>
<?php 

	if(!isset($_SESSION['ad_id'])){
		header("location: ../../auth/login_admin.php");
		exit();
	}

    if(isset($_GET['id'])) {
        $librarian_id = $_GET['id'];
        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $librarian_name = htmlspecialchars($_POST['librarian_name']);
            $librarian_mail = htmlspecialchars($_POST['librarian_mail']);
            $librarian_tel = htmlspecialchars($_POST['librarian_tel']);
            $library_id = $_POST['library_id'];

            $sql = "UPDATE librarian SET librarian_name = ?, librarian_mail = ?, librarian_tel = ?, library_id = ?
                    WHERE librarian_id = ?";

            $stmt = $conn->prepare($sql);
            $stmt->execute([$librarian_name, $librarian_mail, $librarian_tel, $library_id, $librarian_id]);
            header("Location: ../librarian.php?success=true");
			exit();
        } else {
            $sql = "SELECT lb.library_id, lb.librarian_name, l.library_name, lb.librarian_tel, lb.librarian_mail
                    FROM librarian lb
                    JOIN library l ON (lb.library_id = l.library_id)
                    WHERE lb.librarian_id = :librarian_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':librarian_id', $librarian_id, PDO::PARAM_INT);
            $stmt->execute();
            $librarian = $stmt->fetch(PDO::FETCH_ASSOC);

            $sql1 = "SELECT l.library_id, l.library_name
                    FROM library l
                    WHERE l.library_id != ?";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->execute([$librarian['library_id']]);
            $libraries = $stmt1->fetchAll(PDO::FETCH_ASSOC);
        }
    } else {
        header("Location: ../librarian.php");
		exit();
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edition bibliothécaire</title>
	<link rel="stylesheet" href="../../assets/css/libra.css?v=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
	<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="../../assets/css/edit_libra1.css?v=1.0">
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
				<a href="../admin_dash.php">
				<i class='bx bx-grid-alt'></i>
				<span class="links_name">
					Tableau de bord
				</span>
				</a>
			</li>
			<li>
				<a href="../librarian.php" class="active">
				<i class='bx bx-user'></i>
				<span class="links_name">
					Bibliothécaires
				</span>
				</a>
			</li>
			<li>
				<a href="../library.php">
				<i class='bx bx-book-open'></i>
				<span class="links_name">
					Bibliothèques
				</span>
				</a>
			</li>
			<li>
				<a href="../student.php">
				<i class='bx bx-user'></i>
				<span class="links_name">
					Etudiants
				</span>
				</a>
			</li>
			<li>
				<a href="../book.php">
				<i class='bx bx-book' ></i>
				<span class="links_name">
					Livres
				</span>
				</a>
			</li>
			<li>
				<a href="../borrow.php">
				<i class='bx bxs-cart'></i>
				<span class="links_name">
					Emprunts
				</span>
				</a>
			</li>
			<li>
				<a href="../add_library.php">
				<i class='bx bxs-book'></i>
				<span class="links_name">
					Ajouter Bibliothèque
				</span>
				</a>
			</li>
			<li>
				<a href="../add_librarian.php">
				<i class='bx bxs-user-plus'></i>
				<span class="links_name">
					Ajouter Bibliothécaire
				</span>
				</a>
			</li>
			<li>
				<a href="../setting.php">
				<i class='bx bx-cog'></i>
				<span class="links_name">
					Paramètres
				</span>
				</a>
			</li>
			<li class="../login">
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
				<h2>Edition</h2>
				<form id="librarianForm" method="POST">
					<input type="text" style="text-transform:uppercase;" name="librarian_name" id="librarianName" placeholder="Nom" value="<?= $librarian['librarian_name']; ?>" required>
					<div class="error" id="nameError"></div>

					<input type="text" name="librarian_tel" id="librarianTel" placeholder="Téléphone" value="<?= $librarian['librarian_tel']; ?>" required>
					<div class="error" id="telError"></div>

					<input type="email" style="text-transform:lowercase;" name="librarian_mail" id="librarianMail" placeholder="Email" value="<?= $librarian['librarian_mail']; ?>">
					<div class="error" id="mailError"></div>

					<select name="library_id" id="librarySelect" style="text-transform:uppercase;" required>
						<option value="<?= $librarian['library_id']; ?>"><?= $librarian['library_name']; ?></option>
						<?php foreach ($libraries as $library): ?>
							<option value="<?= $library['library_id']; ?>"><?= $library['library_name']; ?></option>
						<?php endforeach; ?>
					</select>
					
					<input type="button" id="submitButton" value="Mettre à jour">
				</form>
			</div>
		</div>
		<div id="previewModal">
    <div class="modal-content" style="text-transform:uppercase;">
        <span class="close-button">&times;</span>
        <h2>Confirmer les modifications</h2>
        <p>Nom: <span id="previewLibrarianName"></span></p>
        <p>Téléphone: <span id="previewLibrarianTel"></span></p>
        <p style="text-transform:lowercase;">Email: <span id="previewLibrarianMail"></span></p>
        <p>Bibliothèque: <span id="previewLibraryName"></span></p>
        <button id="confirmButton">Confirmer</button>
        <button id="cancelButton">Annuler</button>
    </div>
</div>

	</section>

	<script src="../../assets/js/dash.js"></script>
	<script src="../../assets/js/app1.js"></script>
</html>

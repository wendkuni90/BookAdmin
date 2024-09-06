<?php require "../includes/librarian_session.php" ?>
<?php require "../config/config.php" ?>


<?php

    if(!isset($_SESSION['lib_id'])){
        header("location: ../auth/login_biblio.php");
        exit();
    }
    $id = $_SESSION['lib_id'];
    $research = $conn->prepare("SELECT * FROM librarian WHERE librarian_id = '$id'");
    $research->execute();
    $librarian = $research->fetch(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Paramètres</title>
	<link rel="stylesheet" href="../assets/css/libra.css?v=1.0">
    <link rel="stylesheet" href="../assets/css/lib_setting.css">
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
				<a href="librarian_dash.php">
				<i class='bx bx-grid-alt'></i>
				<span class="links_name">
					Tableau de bord
				</span>
				</a>
			</li>
			<li>
				<a href="students.php">
				<i class='bx bx-user'></i>
				<span class="links_name">
					Etudiants
				</span>
				</a>
			</li>
			<li>
				<a href="books.php">
				<i class='bx bx-book-open'></i>
				<span class="links_name">
					Livres
				</span>
				</a>
			</li>
            <li>
				<a href="borrowings.php">
				<i class='bx bxs-cart'></i>
				<span class="links_name">
					Emprunts
				</span>
				</a>
			</li>
			<li>
				<a href="loan.php">
				<i class='bx bxs-cart'></i>
				<span class="links_name">
					Faire un prêt
				</span>
				</a>
			</li>
			<li>
				<a href="add_student.php">
				<i class='bx bxs-user-plus'></i>
				<span class="links_name">
					Ajouter Etudiant
				</span>
				</a>
			</li>
			<li>
				<a href="add_book.php">
				<i class='bx bxs-book'></i>
				<span class="links_name">
					Ajouter Livre
				</span>
				</a>
			</li>
			<li>
				<a href="#" class="active">
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
				<?php if(isset($_SESSION['lib_id'])): ?>
                    <h2 style="text-transform: capitalize; font-size:20px;">
                    	<?php echo $librarian['librarian_name']; ?>
                    </h2>
                <?php endif; ?>
			</div>
		</div>


		<div class="details">
			<h2>Profil Bibliothécaire</h2>
            <form action="scripts/settings_scripts/update_name.php" method="POST">
                <label for="nom">Nom complet:</label>
                <input type="text" id="nom" value="<?= $librarian['librarian_name']; ?>" style="cursor:not-allowed; text-transform:uppercase;" readonly> <br>
				<label for="mail">Email:</label>
				<input type="email" id="mail" value="<?= $librarian['librarian_mail']; ?>" style="cursor:not-allowed;text-transform:lowercase;" readonly> <br>
				<label for="tel">Tel:</label>
				<input type="text" id="tel" value="<?= $librarian['librarian_tel']; ?>" style="cursor:not-allowed;" readonly> <br> <br>
				<h3>Changement des informations du compte</h3>
                <label for="changerNom">Nom:</label>
				<input type="text" id="changerNom" name="name" placeholder="Nom" style="text-transform:uppercase;" value="<?= $librarian['librarian_name']; ?>" required> <br>
				<input type="submit" name="save" value="Enregistrer">
            </form>
            <h3>Changement du mot de passe</h3>
            <form action="scripts/settings_scripts/update_pass.php" method="POST">
				<label for="oldapss">Ancien mot de passe:</label>
				<input type="password" id="oldpass" name="oldpass" required> <br>
				<label for="newapss">Nouveau mot de passe:</label>
				<input type="password" id="newpass" name="newpass" required> <br>
				<label for="conpass">Confirmer mot de passe:</label>
				<input type="password" id="conpass" name="conpass" required> <br>
				<input type="submit" name="change" value="Changer">
			</form>
		</div>
	</section>

	<script src="../assets/js/dash.js"></script>
    <script src="../assets/js/lib_setting.js"></script>
</body>
</html>

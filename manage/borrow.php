<?php require "../includes/admin_session.php" ?>
<?php require "../config/config.php" ?>
<?php 

	if(!isset($_SESSION['ad_name'])){
		header("location: ../auth/login_admin.php");
		exit();
	}

?>

<?php require "scripts/borrow_script/emprunts.php" ?>


<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Panneau Administrateur</title>
	<link rel="stylesheet" href="../assets/css/libra.css?v=1.0">

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
				<a href="borrow.php" class="active">
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
				<div class="card_header">
					<h2>Emprunts</h2>
				</div>
				<table>
					<thead>
						<tr>
							<td>Etudiant</td>
							<td>Livre emprunté</td>
							<td>Date d'emprunt</td>
							<td>Date de retour</td>
							<td>Statut</td>
						</tr>
					</thead>
					<tbody>
						<?php if(!empty($borrows)): ?>
							<?php foreach ($borrows as $borrow): ?>
								<tr>
									<td style="text-transform:uppercase;">
										<?= htmlspecialchars($borrow['student_name']); ?>
									</td>
									<td style="text-transform:uppercase;">
										<?= htmlspecialchars($borrow['book_title']); ?>
									</td>
									<td>
										<?= htmlspecialchars($borrow['borrow_date']); ?>
									</td>
									<td>
										<?= htmlspecialchars($borrow['borrow_return']); ?>
									</td>
									<td>
										<?= htmlspecialchars($borrow['borrow_status']); ?>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td colspan="5">Aucun emprunt à afficher!</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</section>

	<script src="../assets/js/dash.js"></script>
</body>
</html>

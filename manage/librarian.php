<?php require "../includes/admin_session.php" ?>
<?php require "../config/config.php" ?>
<?php 

	if(!isset($_SESSION['ad_name'])){
		header("location: ../auth/login_admin.php");
	}

?>

<?php require "scripts/librarian_script/total_librarian.php" ?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Panneau Administrateur</title>
	<link rel="stylesheet" href="../assets/css/libra.css">
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
				<a href="librarian.php" class="active">
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
					<h2>Bibliothécaires</h2>
				</div>
				<table>
					<thead>
						<tr>
							<td>Numéro</td>
							<td>Nom</td>
							<td>Bibliothèque</td>
							<td>Contact</td>
							<td>Email</td>
							<td>Actions</td>
						</tr>
					</thead>
					<tbody>
						<?php if(!empty($librarians)): ?>
							<?php foreach ($librarians as $librarian): ?>
								<tr>
									<td>
										<?= htmlspecialchars($librarian['librarian_id']); ?>
									</td>
									<td style="text-transform:uppercase;">
										<?= htmlspecialchars($librarian['librarian_name']); ?>
									</td>
									<td style="text-transform:uppercase;">
										<?= htmlspecialchars($librarian['library_name']); ?>
									</td>
									<td>
										<?= htmlspecialchars($librarian['librarian_tel']); ?>
									</td>
									<td style="text-transform:lowercase;">
										<?= htmlspecialchars($librarian['librarian_mail']); ?>
									</td>
									<td style="display:flex;">
										<a href="scripts/edit_librarian.php?id=<?=$librarian['librarian_id'];?>" style="width:32px; height:32px; margin-right:5px">
											<img src="../assets/img/edit.svg" alt="">
										</a> 
										<div style="width:1px;height:22px;background-color:black;"></div>
										<a href="scripts/delete_librarian.php?id=<?=$librarian['librarian_id'];?>" onclick="return confirm('Supprimer bibliothécaire ?');" style="width:32px; height:32px;margin-left:5px">
											<img src="../assets/img/trash.svg" alt="">
										</a>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td>Aucun bibliothécaire.</td>
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

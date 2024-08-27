<?php require "../includes/admin_session.php" ?>
<?php require "../config/config.php" ?>
<?php 

	if(!isset($_SESSION['ad_name'])){
		header("location: ../auth/login_admin.php");
	}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Panneau Administrateur</title>
	<link rel="stylesheet" href="../assets/css/dash.css">

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
				<a href="#" class="active">
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

		<div class="card-boxes">
			<div class="box">
				<div class="right_side">
					<div class="numbers">15</div>
					<div class="box_topic">Bibliothécaires</div>
				</div>
				<i class='bx bx-user'></i>
			</div>

			<div class="box">
				<div class="right_side">
					<div class="numbers">100</div>
					<div class="box_topic">Etudiants</div>
				</div>
				<i class='bx bxs-user'></i>
			</div>
			
			<div class="box">
				<div class="right_side">
					<div class="numbers">500</div>
					<div class="box_topic">Livres</div>
				</div>
				<i class='bx bx-book-open'></i>
			</div>

			<div class="box">
				<div class="right_side">
					<div class="numbers">509</div>
					<div class="box_topic">Emprunts</div>
				</div>
				<i class='bx bxs-cart'></i>
			</div>
		</div>

		<div class="details">
			<div class="recent_project">
				<div class="card_header">
					<h2>Emprunts récents</h2>
				</div>
				<table>
					<thead>
						<tr>
							<td>Livre emprunté</td>
							<td>Emprunteur</td>
							<td>Statut</td>
							<td>Date d'emprunt</td>
						</tr>
					</thead>
					<!-- Nous afficherons que les 10 derniers etudiants et emprunts -->
					<tbody>
						<tr>
							<td>Web app Design System</td>
							<td>108</td>
							<td>
								<span class="badge bg_seccuss">
									Track
								</span>
							</td>
							<td>
								<span class="img_group">
									<img src="img/avatar-2.jpg" alt="">
								</span>
								<span class="img_group">
									<img src="img/avatar-3.jpg" alt="">
								</span>
								<span class="img_group">
									<img src="img/avatar-4.jpg" alt="">
								</span>
									<span class="img_group">
									<span class="initial">+5</span>
								</span>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="recent_customers">
				<div class="card_header">
					<h2>Nouvels étudiants</h2>
				</div>
				<table>
					<tbody>
						<tr>
							<td>
								N00162020221
							</td>
							<td>
								<h4>Christina Mason</h4>
								<span>Christina@gmail.com</span>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</section>

	<script>
		let sidebar = document.querySelector(".sidebar");
		let closeBtn = document.querySelector("#btn");

		closeBtn.addEventListener("click", () => {
			sidebar.classList.toggle("open");
			changeBtnIcon();
		});

		function changeBtnIcon() {
		// Bascule entre les icônes bx-menu et bx-menu-alt-right
			if (sidebar.classList.contains("open")) {
				closeBtn.classList.remove("bx-menu");
				closeBtn.classList.add("bx-menu-alt-right");
			} else {
				closeBtn.classList.remove("bx-menu-alt-right");
				closeBtn.classList.add("bx-menu");
			}
		}

	</script>
</body>
</html>

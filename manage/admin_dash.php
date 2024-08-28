<?php require "../includes/admin_session.php" ?>
<?php require "../config/config.php" ?>
<?php 

	if(!isset($_SESSION['ad_name'])){
		header("location: ../auth/login_admin.php");
	}

?>
<?php require "scripts/total_Student.php" ?>
<?php require "scripts/total_Librarian.php" ?>
<?php require "scripts/total_Book.php" ?>
<?php require "scripts/total_Borrowings.php" ?>
<?php require "scripts/recent_Student.php" ?>
<?php require "scripts/recent_Borrowings.php" ?>

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

		<div class="card-boxes">
			<div class="box">
				<div class="right_side">
					<div class="numbers"> <?php echo $totalLibrarian; ?> </div>
					<div class="box_topic">Bibliothécaires</div>
				</div>
				<i class='bx bx-user'></i>
			</div>

			<div class="box">
				<div class="right_side">
					<div class="numbers"> <?php echo $totalEtudiant; ?> </div>
					<div class="box_topic">Etudiants</div>
				</div>
				<i class='bx bxs-user'></i>
			</div>
			
			<div class="box">
				<div class="right_side">
					<div class="numbers"> <?php echo $totalBook; ?> </div>
					<div class="box_topic">Livres</div>
				</div>
				<i class='bx bx-book-open'></i>
			</div>

			<div class="box">
				<div class="right_side">
					<div class="numbers"> <?php echo $totalEmprunts; ?> </div>
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
							<td>Titre du livre</td>
							<td>Etudiant</td>
							<td>Statut</td>
							<td>Date d'emprunt</td>
						</tr>
					</thead>
					<!-- Nous afficherons que les 10 derniers etudiants et emprunts -->
					<tbody>
						<?php if(!empty($borrows)): ?>
							<?php foreach ($borrows as $borrow): ?>
								<tr>
									<td>
										<?= htmlspecialchars($borrow['book_title']); ?>
									</td>
									<td>
										<?= htmlspecialchars($borrow['student_name']); ?>
									</td>
									<td>
										<span class="badge bg_danger">
											<?= htmlspecialchars($borrow['borrow_status']); ?>
										</span>
									</td>
									<td>
										<?= htmlspecialchars($borrow['borrow_date']); ?>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td colspan="4">Auncun Emprunt en cours trouvé.</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>

			<div class="recent_customers">
				<div class="card_header">
					<h2>Nouvels étudiants</h2>
				</div>
				<table>
					<tbody>
						<?php if(!empty($students)): ?>
							<?php foreach ($students as $student): ?>
								<tr>
									<td style="text-transform: uppercase;">
										<?= htmlspecialchars($student['student_ine']); ?>
									</td>
									<td>
										<h4 style="text-transform: uppercase; font-size:13px;">
											<?= htmlspecialchars($student['student_name']); ?>
										</h4>

										<span style="font-size:12px;">
											<?= htmlspecialchars($student['student_mail']); ?>
										</span>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td colspan="2">Auncun étudiant inscrit il y a moins de 5 jours.</td>
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

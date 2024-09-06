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

<?php require "scripts/books_scripts/total_Books.php" ?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Panneau d'administration</title>
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
				<a href="#" class="active">
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
				<?php if(isset($_SESSION['lib_id'])): ?>
                    <h2 style="text-transform: capitalize; font-size:20px;">
                    	<?php echo $librarian['librarian_name']; ?>
                    </h2>
                <?php endif; ?>
			</div>
		</div>


		<div class="details">
			<div class="recent_project">
				<div class="card_header">
					<h2>Livres</h2>
				</div>
				<table>
					<thead>
						<tr>
							<td>Côte</td>
							<td>Titre</td>
							<td>Auteur</td>
                            <td>Exemplaires</td>
                            <td>Actions</td>
						</tr>
					</thead>
					<tbody>
						<?php if(!empty($books)): ?>
							<?php foreach ($books as $book): ?>
								<tr>
									<td>
										<?= htmlspecialchars($book['book_quote']); ?>
									</td>
									<td>
										<?= htmlspecialchars($book['book_title']); ?>
									</td>
									<td>
                                        <?= htmlspecialchars($book['book_auth']); ?>
									</td>
                                    <td>
                                        <?= htmlspecialchars($book['book_copies']); ?>
                                    </td>
									<td style="display:flex;">
                                        <a href="scripts/edit_book.php?id=<?=$book['book_id'];?>" style="width:32px; height:32px; margin-right:5px">
                                                <img src="../assets/img/edit.svg" alt="">
                                        </a> 
										<div style="width:1px;height:22px;background-color:black;"></div>
										<a href="scripts/delete_book.php?id=<?=$book['book_id'];?>" onclick="return confirm('Supprimer livre ?');" style="width:32px; height:32px;margin-left:5px">
											<img src="../assets/img/trash.svg" alt="">
										</a>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td colspan="5">Aucun Livre trouvé.</td>
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

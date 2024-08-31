<?php require "../../includes/admin_session.php" ?>
<?php require "../../config/config.php" ?>
<?php 

	if(!isset($_SESSION['ad_name'])){
		header("location: ../../auth/login_admin.php");
	}

    if(isset($_GET['id'])) {
        $library_id = $_GET['id'];
        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $library_name = htmlspecialchars($_POST['library_name']);

            $sql = "UPDATE library SET library_name = ?
                    WHERE library_id = ?";

            $stmt = $conn->prepare($sql);
            $stmt->execute([$library_name, $library_id]);
            header("Location: ../library.php");
        } else {

            $sql1 = "SELECT l.library_name
                    FROM library l
                    WHERE l.library_id = ?";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->execute([$library_id]);
            $library = $stmt1->fetch(PDO::FETCH_ASSOC);
        }
    } else {
        header("Location: ../library.php");
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edition Bibliothèque</title>
	<link rel="stylesheet" href="../../assets/css/librarian.css">

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
				<a href="../admin_dash.php">
				<i class='bx bx-grid-alt'></i>
				<span class="links_name">
					Tableau de bord
				</span>
				</a>
			</li>
			<li>
				<a href="../librarian.php">
				<i class='bx bx-user'></i>
				<span class="links_name">
					Bibliothécaires
				</span>
				</a>
			</li>
			<li>
				<a href="../library.php" class="active">
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
				<form method="POST">
                    <input type="text" name="library_name" value="<?= $library['library_name']; ?>" required>
                    <input type="submit" value="Mettre à jour">
                </form>
			</div>
		</div>
	</section>

	<script src="../../assets/js/dash.js"></script>
</body>
</html>

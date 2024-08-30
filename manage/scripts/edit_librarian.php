<?php require "../../includes/admin_session.php" ?>
<?php require "../../config/config.php" ?>
<?php 

	if(!isset($_SESSION['ad_name'])){
		header("location: ../../auth/login_admin.php");
	}

    if(isset($_GET['id'])) {
        $librarian_id = $_GET['id'];
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $librarian_name = htmlspecialchars(trim($_POST['librarian_name']));
            $librarian_mail = htmlspecialchars(trim($_POST['librarian_mail']));
            $librarian_tel = htmlspecialchars(trim($_POST['librarian_tel']));
            //Library_id ne prendra pas la valeur du post. On va chercher le id de la bibliothèque dont le nom a 
            // été passé en paramètre ensuite on place cet id dans libray_id et le tour est joué. 
            // Le pb est que j'aurai a gérer une liste déroulante pour les bays bays mais ca va aller je gère
            $library_id = htmlspecialchars(trim($_POST['library_id']));

            $sql = "UPDATE librarian SET librarian_name = :librarian_name,
                    librarian_mail = :librarian_mail, librarian_tel = :librarian_tel, library_id = :library_id
                    WHERE librarian_id = :librarian_id";

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':librarian_name', $librarian_name);
            $stmt->bindParam(':librarian_mail', $librarian_mail);
            $stmt->bindParam(':librarian_tel', $librarian_tel);
            $stmt->bindParam(':library_id', $library_id, PDO::PARAM_INT);
            $stmt->bindParam(':librarian_id', $librarian_id, PDO::PARAM_INT);

            $stmt->execute();
            header("Location: ../librarian.php");
        } else {
            $sql = "SELECT lb.library_id, lb.librarian_name, l.library_name, lb.librarian_tel, lb.librarian_mail
                    FROM librarian lb
                    JOIN library l ON (lb.library_id = l.library_id)
                    WHERE lb.librarian_id = :librarian_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':librarian_id', $librarian_id, PDO::PARAM_INT);
            $stmt->execute();
            $librarian = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $sql1 = "SELECT l.library_id, l.library_name
                    FROM library l";
            $stmt1 = $conn->prepare($sql);
            $stmt1->execute();
            $libraries = $stmt1->fetchAll(PDO::FETCH_ASSOC);
        }
    } else {
        header("Location: ../librarian.php");
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edition bibliothécaire</title>
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
				
			</div>
		</div>
	</section>

	<script src="../../assets/js/dash.js"></script>
</body>
</html>

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

    //Récupération des étudiants et des livres de la bibliothèque
    $library_id = $librarian['library_id'];
    //Students
    $sql = "SELECT * FROM student WHERE library_id = '$library_id'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //Livres
    $sql = "SELECT * FROM book WHERE library_id = '$library_id'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $livres = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $student_id = $_POST['etudiant'];
        $book_id = $_POST['livre'];

        //Vérifions le nombre d'emprunts en cours pour l'etudiant
        $sql = "SELECT COUNT(*) FROM borrow WHERE student_id = :id AND borrow_status = 'En cours'";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $student_id, PDO::PARAM_INT);
        $stmt->execute();
        $nombre_emprunts = $stmt->fetchColumn();

        if($nombre_emprunts >= 3){
            $error_message = "Nombre limite d'emprunts de cet etudiant atteint.";
        } else {
            //Vérification de la disponibilité du livre
            $sql = "SELECT book_copies FROM book WHERE book_id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $book_id, PDO::PARAM_INT);
            $stmt->execute();
            $nblivre = $stmt->fetch(PDO::FETCH_ASSOC);

            if($nblivre['book_copies'] < 1){
                $error_message = "Ce livre n'est plus disponible";
            } else {
                //Enregistrement de l'emprunt
                $conn->beginTransaction();
                try{
                    //Ajout de l'emprunt
                    $sql = "INSERT INTO borrow (student_id, book_id, borrow_date, borrow_return, librarian_id)
                            VALUES (:stid, :bkid, NOW(), CURDATE()+10, :lbid)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':stid', $student_id, PDO::PARAM_INT);
                    $stmt->bindParam(':bkid', $book_id, PDO::PARAM_INT);
                    $stmt->bindParam(':lbid', $librarian['librarian_id'], PDO::PARAM_INT);
                    $stmt->execute();
    
                    //Mise à jour du nombre d'exemplaires
                    $sql = "UPDATE book SET book_copies = book_copies-1 WHERE book_id = :id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':id', $book_id, PDO::PARAM_INT);
                    $stmt->execute();
    
                    $conn->commit();
                    header("location: borrowings.php");
                    exit();
                } catch (Exception $e) {
                    $conn->rollBack();
                    $error_message = "Erreur lors de l'enregistrement";
                }
            }

        }
    }

?>


<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Panneau d'administration</title>
	<link rel="stylesheet" href="../assets/css/libra.css?v=1.0">
    <link rel="stylesheet" href="../assets/css/loan.css?v=1.0">
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
				<a href="borrowings.php" >
				<i class='bx bxs-cart'></i>
				<span class="links_name">
					Emprunts
				</span>
				</a>
			</li>
			<li>
				<a href="#" class="active">
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

        <div class="container">
            <h1>Prêt de livre</h1>
            <form id="pretForm" method="POST">
                <label for="etudiant">Etudiant: </label>
                <select name="etudiant" id="etudiant" required style="text-transform:uppercase;">
                    <option value="">Sélectionner un étudiant</option>
                    <!-- Les options seront remplies par PHP -->
                    <?php foreach($etudiants as $etudiant): ?>
                        <option value="<?= $etudiant['student_id'] ?>"> <?= htmlspecialchars($etudiant['student_ine']) ?> - <?= htmlspecialchars($etudiant['student_name']) ?> </option>
                    <?php endforeach; ?>
                </select>

                <label for="livre">Livre: </label>
                <select name="livre" id="livre" required style="text-transform:uppercase;">
                    <option value="">Sélectionner un livre</option>
                    <!-- Les options seront remplies par PHP -->
                    <?php foreach($livres as $livre): ?>
                        <option value="<?= $livre['book_id'] ?>"> <?= htmlspecialchars($livre['book_quote']) ?> - <?= htmlspecialchars($livre['book_title']) ?> </option>
                    <?php endforeach; ?>
                </select>

                <div id="message" style="background-color: #f8d7da;color: #721c24;">
                <?php if(!empty($error_message)): ?>
                    <?= $error_message; ?>
                <?php endif; ?>
                </div>
                
                <button type="submit">Prêter</button>
            </form>
            
        </div>

        <script src="../assets/js/loan.js"></script>
		
	</section>

	<script src="../assets/js/dash.js"></script>
</body>
</html>

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

    $library_search = $conn->prepare("SELECT l.library_name, l.library_id FROM library l JOIN librarian lb ON (l.library_id = lb.library_id) WHERE lb.librarian_id = '$id'");
    $library_search->execute();
    $library = $library_search->fetch(PDO::FETCH_ASSOC);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupération des données du formulaire
        $book_title = $_POST['book_title'];
        $book_auth = $_POST['book_auth'];
        $book_quote = $_POST['book_quote'];
        $book_copies = $_POST['book_copies'];
        $library_id = $librarian['library_id'];
    
        // Vérification si le book_quote existe déjà
        $check_stmt = $conn->prepare("SELECT * FROM book WHERE book_quote = :book_quote");
        $check_stmt->bindParam(':book_quote', $book_quote);
        $check_stmt->execute();
        $check = $check_stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($check) {
            $error_message = "Côte existante! Veuillez changer la côte";
        } else {
            // Préparation et exécution de la requête d'insertion
            $sql = "INSERT INTO book (book_title, book_auth, book_quote, book_copies, library_id) 
                    VALUES (:title, :auth, :quote, :copies, :id)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':title', $book_title);
            $stmt->bindParam(':auth', $book_auth);
            $stmt->bindParam(':quote', $book_quote);
            $stmt->bindParam(':copies', $book_copies);
            $stmt->bindParam(':id', $library_id);
            $stmt->execute();

            header("location: books.php");
            exit();
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
    <style>
        .form-container {
            margin: 0 auto;
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 80%;
        }
        h2 {
            color: #2193b0;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
        }
        input, select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        button {
            width: 100%;
            padding: 0.75rem;
            background-color: #2193b0;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #1c7d98;
        }
        .success-message {
            color: green;
            text-align: center;
            margin-top: 1rem;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-top: 1rem;
        }
    </style>
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
				<a href="#" class="active">
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


		<div class="form-container" style="margin-top:20px;">
        <h2>Ajouter un Nouveau Livre</h2>
        <form method="POST" id="addBookForm">
            <div class="form-group">
                <label for="book_title">Titre du Livre</label>
                <input type="text" id="book_title" name="book_title" style="text-transform:uppercase;" required>
            </div>
            <div class="form-group">
                <label for="book_auth">Auteur</label>
                <input type="text" id="book_auth" name="book_auth" style="text-transform:uppercase;" required>
            </div>
            <div class="form-group">
                <label for="book_quote">Code Unique (8 chiffres)</label>
                <input type="int" id="book_quote" name="book_quote" required pattern="\d{8}" maxlength="8">
            </div>
            <div class="form-group">
                <label for="book_copies">Nombre de Copies</label>
                <input type="number" id="book_copies" name="book_copies" required min="1">
            </div>
            <div class="form-group">
                <label for="library_id">Bibliothèque</label>
                <select id="library_id" name="library_id" required readonly style="cursor:not-allowed;text-transform:uppercase;">
                    <option value="<?= $library['library_id'] ?>"> <?= $library['library_name']; ?> </option>
                </select>
            </div>
            <?php if(!empty($error_message)): ?>
                <div id="message" style="color:red;text-align:center;"> <?= $error_message ?> </div>
            <?php endif; ?>
            <button type="submit" name="submit">Ajouter</button>
        </form>
        
    </div>

	</section>

	<script src="../assets/js/dash.js"></script>
</body>
</html>

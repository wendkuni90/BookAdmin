<?php require "../../includes/librarian_session.php" ?>
<?php require "../../config/config.php" ?>


<?php

    if(!isset($_SESSION['lib_id'])){
        header("location: ../../auth/login_biblio.php");
        exit();
    }
    $id = $_SESSION['lib_id'];
    $research = $conn->prepare("SELECT * FROM librarian WHERE librarian_id = '$id'");
    $research->execute();
    $librarian = $research->fetch(PDO::FETCH_ASSOC);

    if(isset($_GET['id'])){
        $book_id = $_GET['id'];
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $book_quote = htmlspecialchars(trim($_POST['book_quote']));
            $book_title = htmlspecialchars(trim($_POST['book_title']));
            $book_auth = htmlspecialchars(trim($_POST['book_auth']));
            $book_copies = $_POST['book_copies'];

            //Verifions que la cote n'existe pas
            $sql = "SELECT book_title FROM book WHERE book_quote = :quote  AND book_id != :id";
            $stmt = $conn->prepare($sql);    
            $stmt->bindParam(':quote', $book_quote);
            $stmt->bindParam(':id', $book_id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if($result){
                header("location: edit_book.php?id=$book_id");
                exit();
            } else {
                $sql = "UPDATE book SET book_title = :title, book_auth = :auth, book_copies = :copies, book_quote = :quote WHERE book_id = :id";            
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':title', $book_title);
                $stmt->bindParam(':auth', $book_auth);
                $stmt->bindParam(':copies', $book_copies);
                $stmt->bindParam(':quote', $book_quote);
                $stmt->bindParam(':id', $book_id, PDO::PARAM_INT);
                $update = $stmt->execute();

                if($update){
                    header("location: ../books.php");
                    exit();
                } else {
                    header("location: edit_book.php?id=$book_id");
                    exit();
                }
            }
        } else {
            $sql = "SELECT * FROM book WHERE book_id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $book_id);
            $stmt->execute();
            $book = $stmt->fetch(PDO::FETCH_ASSOC);
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
	<link rel="stylesheet" href="../../assets/css/libra.css?v=1.0">
    <style>
        .details {
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 65px;
            width: 80%;
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }
        input {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        input:focus {
            outline: none;
            border-color: #4a90e2;
            box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.2);
        }
        button {
            background-color: #4a90e2;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #357abd;
        }
        #message {
            margin-top: 10px;
            padding: 10px;
            border-radius: 4px;
            background-color: #ffebee;
            border: 1px solid #ffcdd2;
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
				<a href="../librarian_dash.php">
				<i class='bx bx-grid-alt'></i>
				<span class="links_name">
					Tableau de bord
				</span>
				</a>
			</li>
			<li>
				<a href="../students.php" >
				<i class='bx bx-user'></i>
				<span class="links_name">
					Etudiants
				</span>
				</a>
			</li>
			<li>
				<a href="../books.php" class="active">
				<i class='bx bx-book-open'></i>
				<span class="links_name">
					Livres
				</span>
				</a>
			</li>
            <li>
				<a href="../borrowings.php">
				<i class='bx bxs-cart'></i>
				<span class="links_name">
					Emprunts
				</span>
				</a>
			</li>
			<li>
				<a href="../loan.php">
				<i class='bx bxs-cart'></i>
				<span class="links_name">
					Faire un prêt
				</span>
				</a>
			</li>
			<li>
				<a href="../add_student.php">
				<i class='bx bxs-user-plus'></i>
				<span class="links_name">
					Ajouter Etudiant
				</span>
				</a>
			</li>
			<li>
				<a href="../add_book.php">
				<i class='bx bxs-book'></i>
				<span class="links_name">
					Ajouter Livre
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
			<li class="login">
				<a href="../logout.php">
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

        <div class="details" style="background:none;">
            <h1>Éditer livre</h1>
            <form method="POST">
                
                <label for="book_quote" >Côte:</label>
                <input type="int" id="book_quote" name="book_quote" value=" <?= htmlspecialchars($book['book_quote']) ?> " required maxlength="8">
                
                <label for="book_title">Titre:</label>
                <input type="text" id="book_title" name="book_title" value=" <?= htmlspecialchars($book['book_title']) ?> " required style="text-transform:uppercase;">
                
                <label for="book_auth">Auteur:</label>
                <input type="text" id="book_auth" name="book_auth" value=" <?= htmlspecialchars($book['book_auth']) ?> " required style="text-transform:uppercase;">

                <label for="book_copies">Exemplaires:</label>
                <input type="int" id="book_copies" name="book_copies" value=" <?= htmlspecialchars($book['book_copies']) ?> " required style="text-transform:uppercase;">

                <?php if(!empty($error_message)): ?>
                <div id="message" style="color:red;text-align:center;"> <?= $error_message ?> </div>
                <?php endif; ?>
                <button type="submit">Mettre à jour</button>
            </form>
        </div>
		
	</section>

	<script src="../../assets/js/dash.js"></script>
</body>
</html>

<?php require "../includes/librarian_session.php" ?>
<?php require "../config/config.php" ?>

<?php
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'vendor/autoload.php';

    if(!isset($_SESSION['lib_id'])){
        header("location: ../auth/login_biblio.php");
        exit();
    }
    

    //Creons un mot de passe unique et aléatoire pour l'etudiant
    function generateUniquePass($conn){
        $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOOPQRSTUVWXYZ';
        $charLength = strlen($char);
        do{
            $randomString = '';
            for($i = 0; $i < 8; $i++){
                $randomString .= $char[rand(0,$charLength-1)];
            }

            //Verifions si le mot de passe existe déjà
            $stmt = $conn->prepare("SELECT student_pass FROM student");
            $stmt->execute();
            $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $exists = 0;
            foreach($students as $student){
                if(password_verify($randomString, $student['student_pass'])){
                    $exists = 1;
                }
            }
        } while ( $exists == 1 ); //Continuer à générer si on rencontre un mm mot de passe existant

        return $randomString;
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
        $student_ine = $_POST['student_ine'];
        $student_name = htmlspecialchars($_POST['student_name']);
        $student_mail = $_POST['student_mail'];
        $library_id = $librarian['library_id'];
    
        // Vérification si l'ine ou le mail existent déjà
        $check_stmt = $conn->prepare("SELECT * FROM student WHERE student_ine = :ine OR student_mail = :mail");
        $check_stmt->bindParam(':ine', $student_ine);
        $check_stmt->bindParam(':mail', $student_mail);
        $check_stmt->execute();
        $check = $check_stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($check) {
            $error_message = "INE ou adresse mail déjà existante.";
        } else {
            // Création du mot de passe et hachage. Ce mot de passe est unique
            $aleatPassword = generateUniquePass($conn);
            $hashed_pass = password_hash($aleatPassword, PASSWORD_DEFAULT);

            //Preparation de la requete d'insertion
            $sql = "INSERT INTO student (student_ine, student_name, student_mail, library_id, student_pass, creation_date)
                    VALUES (:ine, :name, :mail, :id, :pass, NOW())";
            $insert = $conn->prepare($sql);
            $insert->bindParam(':ine', $student_ine);
            $insert->bindParam(':name', $student_name);
            $insert->bindParam(':mail', $student_mail);
            $insert->bindParam(':id', $library_id);
            $insert->bindParam(':pass', $hashed_pass);
            $insert->execute();

            //Envoie d'email avec PHPMailer. C'est une methode plus sécurisée et moins complexes que la focntion native de php qui est php mail()
            //En offline j'utiliserai Mailhog
            //En online j'utiliserai un compte SMTP dedié ou juste une adresse mail dediée
            $student_name = strtoupper($student_name);
            $mail = new PHPMailer(true);
            try{

                //Offline en utilisant Mailhog
                // $mail->isSMTP();
                // $mail->Host = 'localhost';
                // $mail->SMTPAuth = false;
                // $mail->Port = 1025;
                // $mail->setFrom('elielnikiema16@gmail.com', 'Eliel NIKIEMA');
                // $mail->addAddress($student_mail, $student_name);
                // $mail->Subject = 'BookTrack';
                // $mail->Body = "Salut. Vos informations de connexion sont: -- <strong>$aleatPassword</strong> --. Cordialement l'équipe de BookTrack.";

                //Online en utilisant SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'booktrack.team@gmail.com';
                $mail->Password = 'swuiaruroyezulpz';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;
                $mail->setFrom('booktrack.team@gmail.com', 'BookTrack');
                $mail->addAddress($student_mail, $student_name);
                $mail->isHTML(true);
                $mail->Subject = 'Informations de votre compte';
                $mail->Body = "Bonjour $student_name,<br><br>Vos informations de connexion sur la plateforme sont:<br>INE: <strong>$student_ine</strong>,<br>Mot de passe: <strong>$aleatPassword</strong>. <br><br>Cordialement, l'équipe de BookTrack.";
                $mail->AltBody = "Bonjour <strong>$student_name</strong>,\n\nVos informations de connexion sur la plateforme sont:\nINE: $student_ine,\nMot de passe: $aleatPassword. \n\nCordialement, l'équipe de BookTrack.";

                $mail->send();
                header("location: students.php");
                exit();
            }catch(Exception $e) {

                echo "L'envoi de l'email a échoué. Erreur: {$mail->ErrorInfo}";
        
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
				<a href="#" class="active">
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


		<div class="form-container" style="margin-top:48px;">
        <h2>Ajouter Etudiant</h2>
        <form method="POST" id="addBookForm">
            <div class="form-group">
                <label for="student_ine">N° INE</label>
                <input type="text" id="student_ine" name="student_ine" style="text-transform:uppercase;" value="N" required  maxlength="12">
            </div>
            <div class="form-group">
                <label for="student_name">Nom complet</label>
                <input type="text" id="student_name" name="student_name" style="text-transform:uppercase;" required>
            </div>
            <div class="form-group">
                <label for="student_mail">Adresse mail</label>
                <input type="text" id="student_mail" name="student_mail" style="text-transform:lowercase;" required>
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

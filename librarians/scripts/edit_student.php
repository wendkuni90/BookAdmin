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
        $student_id = $_GET['id'];
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $student_name = htmlspecialchars($_POST['student_name']);
            $student_mail = $_POST['student_mail'];
            $student_ine = $_POST['student_ine'];

            //Verifiions que l'email ou l'ine n'existe pas déjà
            $sql = "SELECT student_name FROM student WHERE (student_ine = :ine OR student_mail = :mail) AND student_id != :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':ine', $student_ine);
            $stmt->bindParam(':mail', $student_mail);
            $stmt->bindParam(':id', $student_id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if($result){
                header("location: edit_student.php?id=$student_id");
                exit();
            } else {
                $sql = "UPDATE student SET student_name = :name, student_ine = :ine, student_mail = :mail WHERE student_id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':name', $student_name);
                $stmt->bindParam(':ine', $student_ine);
                $stmt->bindParam(':mail', $student_mail);
                $stmt->bindParam(':id', $student_id, PDO::PARAM_INT);
                $update = $stmt->execute();

                if($update){
                    header("location: ../students.php");
                    exit();
                } else {
                    header("location: edit_student.php?id=$student_id");
                    exit();
                }

            }

        } else {
            $sql = "SELECT student_name, student_mail, student_ine FROM student WHERE student_id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $student_id);
            $stmt->execute();
            $student = $stmt->fetch(PDO::FETCH_ASSOC);
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
            margin-top: 80px;
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
				<a href="librarian_dash.php">
				<i class='bx bx-grid-alt'></i>
				<span class="links_name">
					Tableau de bord
				</span>
				</a>
			</li>
			<li>
				<a href="" class="active">
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

        <div class="details" style="background:none;">
            <h1>Éditer l'étudiant</h1>
            <form method="POST">
                
                <label for="student_name" >Nom:</label>
                <input type="text" id="student_name" name="student_name" value="<?= htmlspecialchars($student['student_name']) ?>" required style="text-transform:capitalize;">
                
                <label for="student_mail">Mail:</label>
                <input type="text" id="student_mail" name="student_mail" value="<?= htmlspecialchars($student['student_mail']) ?>" required style="text-transform:lowercase;">
                
                <label for="student_ine">INE:</label>
                <input type="text" id="student_ine" name="student_ine" value="<?= htmlspecialchars($student['student_ine']) ?>" required maxlength="12">
                <?php if(!empty($error_message)): ?>
                <div id="message" style="color:red;text-align:center;"> <?= $error_message ?> </div>
                <?php endif; ?>
                <button type="submit">Mettre à jour</button>
            </form>
        </div>
		
	</section>

	<script src="../assets/js/dash.js"></script>
</body>
</html>

<!-- Le fichier principal sera une page de connexion 
pour (L'Admin et les Bibliothécaires) 
Notons que si la session du bibliothécaire est lancée il ne peux plus avoir
à cette page de même pour l'administrateur
-->
<?php require "../includes/librarian_session.php" ?>
<?php require "../config/config.php" ?>

<?php 

    if(isset($_SESSION['lib_id'])){
        header("location: ../librarians/librarian_dash.php");
        exit();
    }
    if(isset($_POST['bib_submit'])){
        if(empty($_POST['bib_name']) OR empty($_POST['bib_pass'])){
            echo "<script>alert('Attention: Un des champs est vide.')</script>";
        } else {
            $bib_name = trim($_POST['bib_name']);
            $bib_pass = $_POST['bib_pass'];

            //Requête préparée por éviter les injections sql
            $stmt = $conn->prepare("SELECT * FROM librarian WHERE librarian_name = :name");
            $stmt->bindParam(':name', $bib_name);
            $stmt->execute();
            $fetch = $stmt->fetch(PDO::FETCH_ASSOC);

            //Verifions si c'est sa premiere fois et si le mdp par défaut qu'il a saisi est correct
            if($fetch && password_verify($bib_pass,$fetch['librarian_pass'])){
                if($fetch['must_changes']){
                    $id = $fetch['librarian_id'];
                    header("location: change_biblio.php?id=$id");
                    exit();
                } else {
                    $_SESSION['lib_id'] = $fetch['librarian_id'];
                    header("location: ../librarians/librarian_dash.php");
                    exit();
                }
            } else {
                $error_message = "Données incorrects";
            }
        }
    }

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="../assets/css/login_admin.css?v=1.0">
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h1>Connexion</h1>
            <form action="#" method="POST">
                <div class="textbox">
                    <input type="text" name="bib_name" required>
                    <span class="placeholder">Nom</span>
                </div>
                <div class="textbox">
                    <input type="password" name="bib_pass" required>
                    <span class="placeholder">Mot de passe</span>
                </div>
                <?php if (!empty($error_message)): ?>
                    <p class="error"><?= htmlspecialchars($error_message) ?></p>
                <?php endif; ?>
                <button type="submit" name="bib_submit">Se Connecter</button>
            </form>
        </div>
    </div>
</body>
</html>

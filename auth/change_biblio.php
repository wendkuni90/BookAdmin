<?php require "../includes/librarian_session.php" ?>
<?php require "../config/config.php" ?>

<?php 

    if(isset($_SESSION['lib_id'])){
        header("location: ../librarians/librarian_dash.php");
        exit();
    }
    $lib_id = $_GET['id'];
    $val = $conn->prepare("SELECT librarian_name FROM librarian WHERE librarian_id = '$lib_id'");
    $val->execute();
    $resul = $val->fetch(PDO::FETCH_ASSOC);
    if(isset($_POST['bib_submit'])){
        if(empty($_POST['oldpass']) OR empty($_POST['newpass']) OR empty($_POST['conpass'])){
            echo "<script>alert('Attention: Un des champs est vide.')</script>";
        } else {
            $lib_id = $_GET['id'];
            $oldpass = $_POST['oldpass'];
            $newpass = $_POST['newpass'];
            $conpass = $_POST['conpass'];

            //Je vais vérifier si le oldpass correspond au mdp actuel du bibliohécaire
            $sql = "SELECT librarian_pass FROM librarian WHERE librarian_id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $lib_id, PDO::PARAM_INT);
            $stmt->execute();
            $librarian = $stmt->fetch(PDO::FETCH_ASSOC);

            if($librarian && password_verify($oldpass, $librarian['librarian_pass'])){
                //Vérifions maintenant si ces deux nouveaux mdp correspondent
                if($newpass === $conpass){
                    //Ok updatons son mot de passe ainsi que son 'must_change' et dirigeons le à la page de connexion
                    $hashed_pass = password_hash($newpass, PASSWORD_DEFAULT);
                    $must_changes = 0;
                    $update = "UPDATE librarian SET librarian_pass = :password, must_changes = :change WHERE librarian_id = :id";
                    $up_stmt = $conn->prepare($update);
                    $up_stmt->bindParam(':password', $hashed_pass);
                    $up_stmt->bindParam(':change', $must_changes, PDO::PARAM_INT);
                    $up_stmt->bindParam(':id', $lib_id, PDO::PARAM_INT);

                    if($up_stmt->execute()){
                        session_start();
                        session_unset();
                        session_destroy();
                        header("location: login_biblio.php");
                        exit();
                    } else {
                        $error_message = "Données incorrects.";
                    }
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
            <h1>Mot de passe</h1>
            <form action="#" method="POST">
                <div class="textbox">
                    <input type="text" name="name" value="<?= $resul['librarian_name']; ?>" required>
                    <span class="placeholder">Nom</span>
                </div>
                <div class="textbox">
                    <input type="password" name="oldpass" required>
                    <span class="placeholder">Ancien mot de passe</span>
                </div>
                <div class="textbox">
                    <input type="password" name="newpass" required>
                    <span class="placeholder">Nouveau mot de passe</span>
                </div>
                <div class="textbox">
                    <input type="password" name="conpass" required>
                    <span class="placeholder">Confirmer mot de passe</span>
                </div>
                <?php if (!empty($error_message)): ?>
                    <p class="error"><?= htmlspecialchars($error_message) ?></p>
                <?php endif; ?>
                <button type="submit" name="bib_submit">Changer</button>
            </form>
        </div>
    </div>
</body>
</html>

<!-- Le fichier principal sera une page de connexion 
pour (L'Admin et les Bibliothécaires) 
Notons que si la session du bibliothécaire est lancée il ne peux plus avoir
à cette page de même pour l'administrateur
-->
<?php require "../includes/admin_session.php" ?>
<?php require "../config/config.php" ?>

<?php

    if(isset($_POST['ad_submit'])){
        if(empty($_POST['ad_name']) OR empty($_POST['ad_pass'])){
            echo "<script>alert('Attention: Un des champs est vide.')</script>";
        } else {
            $ad_name = $_POST['ad_name'];
            $ad_passwd = $_POST['ad_pass'];

            // Requête préparée pour éviter les injections SQL
            $stmt = $conn->prepare("SELECT * FROM admin WHERE admin_name = :name");
            $stmt->bindParam(':name', $ad_name);
            $stmt->execute();
            $fetch = $stmt->fetch(PDO::FETCH_ASSOC);

            // Validation du mot de passe
            if($fetch && password_verify($ad_passwd, $fetch['admin_pass'])){
                echo "<script>alert('Connecté.')</script>";
            } else {
                echo "<script>alert('Accès refusé.')</script>";
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
    <link rel="stylesheet" href="../assets/css/login_admin.css">
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h1>Administrateur</h1>
            <form action="#" method="POST">
                <div class="textbox">
                    <input type="text" name="ad_name" required>
                    <span class="placeholder">Nom</span>
                </div>
                <div class="textbox">
                    <input type="password" name="ad_pass" required>
                    <span class="placeholder">Mot de passe</span>
                </div>
                <button type="submit" name="ad_submit">Se Connecter</button>
            </form>
        </div>
    </div>
</body>
</html>
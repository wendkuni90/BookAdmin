<!-- Le fichier principal sera une page de connexion 
pour (L'Admin et les Bibliothécaires) 
Notons que si la session du bibliothécaire est lancée il ne peux plus avoir
à cette page de même pour l'administrateur
-->
<?php require "config/config.php" ?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="assets/css/login_admin.css">
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
                <button type="submit" name="bib_submit">Se Connecter</button>
            </form>
        </div>
    </div>
</body>
</html>

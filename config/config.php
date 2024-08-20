<!-- C'est dans ce fichier que la configuration sera faite:
    Connexion à la base de donnée. Nous utiliserons PDO pour 
    cette connexion.
-->

<?php

    try{
        define("HOST", "localhost");
        define("DBNAME", "booktrack");
        define("LOGIN", "root");
        define("PASS", "");

        $conn = new PDO("mysql:host=".HOST.";dbname=".DBNAME."",LOGIN,PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    }catch(PDOException $e){

        echo "<strong>ERREUR DE CONNEXION: </strong> ".$e->getMessage()."<br>";

    }

?>
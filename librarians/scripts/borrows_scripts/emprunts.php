<?php

    if(!isset($_SESSION['lib_id'])){
        header("location: ../../../auth/login_biblio.php");
        exit();
    }

    // Fonction pour afficher un tableau d'emprunts
    function afficherTableauEmprunts($emprunts, $titre, $editable = false) {
        if(empty($emprunts)) {
            echo "<h2>$titre</h2>";
            echo "<p>Aucun résultat trouvé.</p>";
            return;
        }

        echo "<h2>$titre</h2>";
        echo "<table>";
        echo "<tr><th>Etudiant</th><th>Livre</th><th>Date d'emprunt</th><th>Date de retour</th>";
        if($editable) {
            echo "<th>Action</th>";
        }
        echo "</tr>";
        foreach ($emprunts as $emprunt) {
            echo "<tr>";
            echo "<td>" .htmlspecialchars($emprunt['student_name']). "</td>";
            echo "<td>" .htmlspecialchars($emprunt['book_title']). "</td>";
            echo "<td>" .$emprunt['borrow_date']. "</td>";
            echo "<td>" .$emprunt['borrow_return']. "</td>";
            if($editable) {
                echo "<td><a href='scripts/borrows_scripts/marquer_retourne.php?id=".$emprunt['borrow_id']."' class='btn'>Marquer comme retourné</a></td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    // Mettre à jour les emprunts en retard
    //Ce bout de code permet de changer les emprunts en cours en emprunts en retard là où la date de retour est dépassée
    $sql = "UPDATE borrow SET borrow_status = 'En retard' WHERE borrow_status = 'En cours' AND borrow_return < CURDATE()";
    $stmt = $conn->query($sql);

    //Envoyer les notifications pour les nouveaux emprunts en retard
    // Après je mettrai ce code

    // Préparer la clause WHERE pour la recherche
    // $searchWhere = "";
    // $searchParams = [];
    // if(isset($_GET['search']) && !empty($_GET['search'])) {
    //     $search = $_GET['search'];
    //     $searchWhere = " AND (s.student_name LIKE ? OR bk.book_title LIKE ?)";
    //     $searchParams = ["%search%", "%search%"];
    // }

    //Fonction pour récupérer les emprunts avec recherche
    function getEmprunts($conn, $status) {
        $query = "SELECT b.borrow_id, s.student_name, bk.book_title, b.borrow_date, b.borrow_return
                    FROM borrow b
                    JOIN student s ON b.student_id = s.student_id
                    JOIN book bk ON b.book_id = bk.book_id
                    WHERE b.borrow_status = ?
                    ORDER BY b.borrow_date DESC";
        $stmt = $conn->prepare($query);
        $params = array_merge([$status]);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les emprunts avec la recherche appliquée
    $empruntsCourants = getEmprunts($conn, 'En cours');
    $empruntsRetard = getEmprunts($conn, 'Retard');
    $empruntsRetournes = getEmprunts($conn, 'Retourné');

?>
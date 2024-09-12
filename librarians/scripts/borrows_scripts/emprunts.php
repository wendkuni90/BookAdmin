<?php

    if(!isset($_SESSION['lib_id'])){
        header("location: ../../../auth/login_biblio.php");
        exit();
    }
    $librarian_id = $_SESSION['lib_id'];
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
    $sql = "UPDATE borrow SET borrow_status = 'Retard' WHERE borrow_status = 'En cours' AND borrow_return < CURDATE()";
    $stmt = $conn->query($sql);

    //Envoyer les notifications pour les nouveaux emprunts en retard
    // Après je mettrai ce code
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'vendor/autoload.php';
    
    $stmt = $conn->query("SELECT b.borrow_id, s.student_mail, s.student_name, bk.book_title
            FROM borrow b
            JOIN student s ON b.student_id = s.student_id
            JOIN book bk ON b.book_id = bk.book_id
            WHERE b.borrow_status = 'Retard' AND b.notification_sent = 0");
    $newRetards = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($newRetards as $retard){
        $retard['student_name'] = strtoupper($retard['student_name']);
        $student_name = strtoupper($retard['student_name']);
        $book_title = strtoupper($retard['book_title']);
        $mail = new PHPMailer(true);
        try{
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'booktrack.team@gmail.com';
            $mail->Password = 'swuiaruroyezulpz';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->setFrom('booktrack.team@gmail.com', 'BookTrack');
            $mail->addAddress($retard['student_mail'], $retard['student_name']);
            $mail->isHTML(true);
            $mail->Subject = 'Retard de retour';
            
            $mail->Body = "Bonjour <strong>$student_name</strong>,<br><br>Votre emprunt du livre <strong>$book_title</strong> est en retard.<br>Veuillez le retourner dès que possible.<br><br>Cordialement, la bibliothèque.";
            $mail->AltBody = "Bonjour <strong>$student_name</strong>,\n\nVotre emprunt du livre <strong>$book_title</strong> est en retard.\nVeuillez le retourner dès que possible.\n\nCordialement, l'équipe de BookTrack.";

            $mail->send();
            //Marquer la notification comme envoyée
            $stmt = $conn->prepare("UPDATE borrow SET notification_sent = 1 WHERE borrow_id = ?");
            $stmt->execute([$retard['borrow_id']]);
        }catch(Exception $e){

        }
    }
    

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
        $librarian_id = $_SESSION['lib_id'];
        $query = "SELECT b.borrow_id, s.student_name, bk.book_title, b.borrow_date, b.borrow_return
                    FROM borrow b
                    JOIN student s ON b.student_id = s.student_id
                    JOIN book bk ON b.book_id = bk.book_id
                    WHERE b.borrow_status = ? AND b.librarian_id = ?
                    ORDER BY b.borrow_date DESC";
        $stmt = $conn->prepare($query);
        $params = array_merge([$status,$librarian_id]);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les emprunts avec la recherche appliquée
    $empruntsCourants = getEmprunts($conn, 'En cours');
    $empruntsRetard = getEmprunts($conn, 'Retard');
    $empruntsRetournes = getEmprunts($conn, 'Retourné');

?>
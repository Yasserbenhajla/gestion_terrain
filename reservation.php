<?php


session_start();

if ($_SESSION['logedin'] !== true) {
    header("Location: login.html");
    exit();
}
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "terrain";

$conn = new mysqli($servername, $username, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $nom = $_POST['nom'];
    $date = $_POST['date'];
    $heure_debut = $_POST['heure_debut'];
    $heure_fin = $_POST['heure_fin'];
    $terrain = $_POST['terrain'];
    $reservation_id = $_POST['reservation_id'];

    if ($action == "add") {
        $sql = "INSERT INTO reservation (nom, date, heure_debut, heure_fin, terrain) VALUES ('$nom', '$date', '$heure_debut', '$heure_fin', '$terrain')";
        
        if ($conn->query($sql) === TRUE) {
            $message = "Réservation effectuée avec succès !";
        } else {
            $error = "Erreur lors de la réservation : " . $conn->error;
        }
    } elseif ($action == "update" && !empty($reservation_id)) {
        $sql = "UPDATE reservation SET nom='$nom', date='$date', heure_debut='$heure_debut', heure_fin='$heure_fin', terrain='$terrain' WHERE id=$reservation_id";
        
        if ($conn->query($sql) === TRUE) {
            $message = "Réservation mise à jour avec succès !";
        } else {
            $error = "Erreur lors de la mise à jour de la réservation : " . $conn->error;
        }
    } elseif ($action == "delete" && !empty($reservation_id)) {
        $sql = "DELETE FROM reservation WHERE id=$reservation_id";
        
        if ($conn->query($sql) === TRUE) {
            $message = "Réservation supprimée avec succès !";
        } else {
            $error = "Erreur lors de la suppression de la réservation : " . $conn->error;
        }
    } else {
        $error = "ID de réservation requis pour modification ou suppression.";
    }
} else {
    $error = "Le formulaire n'a pas été soumis.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultat de la Réservation</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="form-container mt-5">
                    <?php
                    if (isset($error)) {
                        echo "<p class='text-danger text-center'>$error</p>";
                    } elseif (isset($message)) {
                        echo "<p class='text-success text-center'>$message</p>";
                    }
                    ?>
                    <div class="text-center mt-3">
                        <a href="reservation.html" class="btn btn-primary">Retour à la gestion des réservations</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

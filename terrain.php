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
    $nom_terrain = $_POST['nom_terrain'];
    $disponibilite = $_POST['disponibilite'];
    $terrain_id = $_POST['terrain_id'];

    if ($action == "add") {
        $sql = "INSERT INTO terrains (nom_terrain, disponibilite) VALUES ('$nom_terrain', '$disponibilite')";
        
        if ($conn->query($sql) === TRUE) {
            $message = "Terrain ajouté avec succès !";
        } else {
            $error = "Erreur lors de l'ajout du terrain : " . $conn->error;
        }
    } elseif ($action == "update" && !empty($terrain_id)) {
        $sql = "UPDATE terrains SET nom_terrain='$nom_terrain', disponibilite='$disponibilite' WHERE id=$terrain_id";
        
        if ($conn->query($sql) === TRUE) {
            $message = "Terrain mis à jour avec succès !";
        } else {
            $error = "Erreur lors de la mise à jour du terrain : " . $conn->error;
        }
    } elseif ($action == "delete" && !empty($terrain_id)) {
        $sql = "DELETE FROM terrains WHERE id=$terrain_id";
        
        if ($conn->query($sql) === TRUE) {
            $message = "Terrain supprimé avec succès !";
        } else {
            $error = "Erreur lors de la suppression du terrain : " . $conn->error;
        }
    } else {
        $error = "ID de terrain requis pour modification ou suppression.";
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
    <title>Résultat de la Gestion des Terrains</title>
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
                        <a href="terrain.html" class="btn btn-primary">Retour à la gestion des terrains</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

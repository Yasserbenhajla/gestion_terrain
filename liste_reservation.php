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
    $reservation_id = $_POST['reservation_id'];
    $action = $_POST['action'];
    
    if ($action == "accepter") {
        $sql = "UPDATE reservation SET status='Acceptée' WHERE id=$reservation_id";
    } elseif ($action == "refuser") {
        $sql = "UPDATE reservation SET status='Refusée' WHERE id=$reservation_id";
    }

    if ($conn->query($sql) === TRUE) {
        $message = "Réservation mise à jour avec succès !";
    } else {
        $error = "Erreur lors de la mise à jour de la réservation : " . $conn->error;
    }
}

$sql = "SELECT * FROM reservation";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des réservations</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .table thead th {
            background-color: #007bff;
            color: white;
        }
        .btn {
            margin-right: 5px;
        }
        .message {
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Liste des réservations</h2>
      

        <?php if (isset($error)): ?>
            <div class="alert alert-danger message"><?php echo $error; ?></div>
        <?php elseif (isset($message)): ?>
            <div class="alert alert-success message"><?php echo $message; ?></div>
        <?php endif; ?>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Date</th>
                    <th>Heure début</th>
                    <th>Heure fin</th>
                    <th>Terrain</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['nom']; ?></td>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo $row['heure_debut']; ?></td>
                            <td><?php echo $row['heure_fin']; ?></td>
                            <td><?php echo $row['terrain']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td>
                                <?php if ($row['status'] == 'En attente'): ?>
                                    <form action="" method="post" style="display:inline;">
                                        <input type="hidden" name="reservation_id" value="<?php echo $row['id']; ?>">
                                        <input type="hidden" name="action" value="accepter">
                                        <button type="submit" class="btn btn-success">Accepter</button>
                                    </form>
                                    <form action="" method="post" style="display:inline;">
                                        <input type="hidden" name="reservation_id" value="<?php echo $row['id']; ?>">
                                        <input type="hidden" name="action" value="refuser">
                                        <button type="submit" class="btn btn-danger">Refuser</button>
                                    </form>
                                <?php else: ?>
                                    <span class="badge badge-secondary"><?php echo $row['status']; ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Aucune réservation trouvée</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php

$conn->close();
?>

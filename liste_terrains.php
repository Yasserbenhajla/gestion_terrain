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


$search_query = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['search'])) {
       
        $search_query = $_POST['search_query'];
        $sql = "SELECT * FROM terrains WHERE nom_terrain LIKE '%$search_query%'";
    } else {
       
    }
} else {
   
    $sql = "SELECT * FROM terrains";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des terrains</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
 
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Liste des terrains</h2>
        <form class="form-inline mb-3" method="post" action="">
            <input class="form-control mr-sm-2" type="text" name="search_query" placeholder="Rechercher un terrain par nom" value="<?php echo htmlspecialchars($search_query); ?>">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search">Rechercher</button>
        </form>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nom du terrain</th>
                    <th>Disponibilité</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['nom_terrain']; ?></td>
                            <td><?php echo $row['disponibilite']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2" class="text-center">Aucun terrain trouvé</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
<style>

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}


body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    color: #333;
}

.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}


.form-inline {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

.form-control {
    width: 70%;
}

.btn-outline-success {
    margin-left: 10px;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th, .table td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

.table th {
    background-color: #f8f9fa;
    font-weight: bold;
}

.table-striped tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}


.text-center {
    text-align: center;
}

</style>
</html>

<?php

$conn->close();
?>

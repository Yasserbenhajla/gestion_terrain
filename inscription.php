<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = $_POST['password'];


    $servername = "localhost";
    $username = "root"; 
    $password_db = ""; 
    $dbname = "terrain";


    $conn = new mysqli($servername, $username, $password_db, $dbname);


    if ($conn->connect_error) {
        die("Connexion échouée : " . $conn->connect_error);
    }

    $req = "INSERT INTO users (nom, email, password) VALUES ('$prenom', '$email', '$password')";

    if ($conn->query($req) === TRUE) {
        echo "Inscription réussie !";
        header("Location: login.html");
        exit();
    } else {
        echo "Erreur lors de l'inscription : " . $conn->error;
    }


    $conn->close();
} 
else {
    echo "Le formulaire n'a pas été soumis.";
}
?>

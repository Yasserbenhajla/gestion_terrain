<?php

session_start();
include ('nav.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $servername = "localhost";
    $username = "root"; 
    $password_db = ""; 
    $dbname = "terrain";
    $_SESSION['logedin'] = true;
    if ($role == 'admin') {
        header("Location: /projet%20d'integration/Accueil_admin");
    } else {
        header("Location: /projet%20d'integration/Acceuil_user.html");
    }
    exit();

    $conn = new mysqli($servername, $username, $password_db, $dbname);

    if ($conn->connect_error) {
        die("Connexion échouée : " . $conn->connect_error);
    }

   
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ? AND role = ?");
    $stmt->bind_param("sss", $email, $password, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
       
        $_SESSION['logedin'] = true;
        echo($_SESSION['logedin']);
        if ($role == "admin") {
            header("Location: Accueil_admin.html");
        } else {
            header("Location: Accueil_user.html");
        }
        exit();
    } else {
        $error = "Adresse e-mail, mot de passe ou rôle incorrect.";
    }

    $stmt->close();
    $conn->close();
}
?>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

 
    $to = "votre_email@example.com";

    $subject = "Nouveau message de la part de $name";

    $message_content = "Nom: $name\n";
    $message_content .= "Email: $email\n\n";
    $message_content .= "Message:\n$message\n";

    $headers = "From: $name <$email>\n";
    $headers .= "Reply-To: $name <$email>\n";
    $headers .= "Content-Type: text/plain; charset=\"utf-8\"\n";

  
    if (mail($to, $subject, $message_content, $headers)) {
        echo "Votre message a été envoyé avec succès.";
    } else {
        echo "Une erreur s'est produite lors de l'envoi de votre message.";
    }

} else {
    echo "Le formulaire n'a pas été soumis.";
}

?>

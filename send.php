<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
</head>
<body>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once "Connexion_oublie.php";
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if (isset($_POST["send"])){
    $email = $_POST['email'];
    $mail = new PHPMailer(true);

    try {
        // Vérifier si l'email existe
        $checkEmail = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $checkEmail->bind_param("s", $email);
        $checkEmail->execute();
        $result = $checkEmail->get_result();

        if ($result->num_rows == 0) {
            // L'email n'existe pas, créer un nouvel utilisateur
            $insertUser = $conn->prepare("INSERT INTO users (email, password) VALUES (?, '')");
            $insertUser->bind_param("s", $email);
            $insertUser->execute();
        }

        // Générer un code de réinitialisation de mot de passe
        $verificationCode = bin2hex(random_bytes(3));

        // Mettre à jour le code de réinitialisation pour l'utilisateur
        $updateCode = $conn->prepare("UPDATE users SET reset_code = ? WHERE email = ?");
        $updateCode->bind_param("ss", $verificationCode, $email);
        $updateCode->execute();

        // Configuration du serveur de messagerie
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'yasminefbe@gmail.com';
        $mail->Password = 'zsbftcmfhrpdpiqz';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('yasminefbe@gmail.com', 'FBE Explorer');
        $mail->addAddress($email);

        // Contenu de l'email
        $mail->isHTML(true);
        $mail->Subject = "Réinitialisation de votre mot de passe";
        $mail->Body = "Votre code de réinitialisation de mot de passe est : " . $verificationCode;

        // Envoi de l'email
        $mail->send();
        echo "<script>alert('Un code de réinitialisation a été envoyé à votre adresse e-mail.');document.location.href = 'verifier_code.php';</script>";
    } catch (Exception $e) {
        echo 'Le message n\'a pas pu être envoyé. Erreur : ' . $mail->ErrorInfo;
    }
}
?>
</body>
</html>

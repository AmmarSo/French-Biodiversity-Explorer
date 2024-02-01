<?php
session_start();
if (isset($_SESSION['user'])) {
    if (isset($_POST['id_message']) && isset($_POST['id_utilisateur_session'])) {
        $id_message = $_POST['id_message'];
        $id_envoi = $_POST['id_utilisateur_session'];

        // Connexion à la base de données
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "test data import";
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connexion échouée : " . $conn->connect_error);
        }

        // Insertion du signalement dans la base de données
        $stmt = $conn->prepare("INSERT INTO signalement (id_message, id_envoi) VALUES (?, ?)");
        $stmt->bind_param("ii", $id_message, $id_envoi);
        $stmt->execute();

        $stmt->close();
        $conn->close();

        // Redirection vers la page de chat
        header('Location: chat.php');
    }
} else {
    echo "Utilisateur non connecté.";
}
?>

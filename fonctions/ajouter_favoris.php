<?php
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    // Redirigez l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: connexion.php");
    exit();
}

// Vérifiez si l'ID de l'espèce a été transmis par le formulaire
if (isset($_POST['espece_id'])) {
    // Récupérez l'ID de l'espèce depuis le formulaire
    $espece_id = $_POST['espece_id'];
    $user_id = $_POST['user_id'];

    // Établissez une connexion à la base de données (remplacez les paramètres de connexion par les vôtres)
    $pdo = new PDO("mysql:host=;dbname=test data import", "root", "");

    // Vérifiez d'abord si l'espèce est déjà dans les favoris de l'utilisateur
    $stmt = $pdo->prepare("SELECT id FROM favoris WHERE user_id = :user_id AND espece_id = :espece_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':espece_id', $espece_id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // L'espèce est déjà dans les favoris, vous pouvez la supprimer
        $stmt = $pdo->prepare("DELETE FROM favoris WHERE user_id = :user_id AND espece_id = :espece_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':espece_id', $espece_id);
        if ($stmt->execute()) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            echo "Une erreur est survenue lors de la suppression de l'espèce des favoris.";
        }
    } else {
        // L'espèce n'est pas dans les favoris, vous pouvez l'ajouter
        $stmt = $pdo->prepare("INSERT INTO favoris (user_id, espece_id) VALUES (:user_id, :espece_id)");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':espece_id', $espece_id);
        if ($stmt->execute()) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
     exit();
        } else {
            echo "Une erreur est survenue lors de l'ajout de l'espèce aux favoris.";
        }
    }
} else {
    echo "L'ID de l'espèce n'a pas été transmis.";
}

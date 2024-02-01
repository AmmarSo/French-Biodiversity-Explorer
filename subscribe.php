<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: connexion.php");
    exit();
}

if (isset($_POST['id_abonne']) && isset($_POST['id_collection'])) {
    $id_abonne = $_POST['id_abonne'];
    $id_collection = $_POST['id_collection'];

    // Établissez une connexion à la base de données (remplacez les paramètres de connexion par les vôtres)
    $mysqli = new mysqli("localhost", "root", "", "test data import");

    if ($mysqli->connect_error) {
        die("La connexion à la base de données a échoué : " . $mysqli->connect_error);
    }

    // Vérifiez d'abord si l'abonnement existe déjà
    $stmt = $mysqli->prepare("SELECT id FROM abonnement WHERE id_abonne = ? AND id_collection = ?");
    $stmt->bind_param("ii", $id_abonne, $id_collection);
    $stmt->execute();
    $stmt->store_result();  // Stocker le résultat pour obtenir le nombre de lignes

    if ($stmt->num_rows > 0) {
        // L'abonnement existe, vous pouvez le supprimer
        $stmt = $mysqli->prepare("DELETE FROM abonnement WHERE id_abonne = ? AND id_collection = ?");
        $stmt->bind_param("ii", $id_abonne, $id_collection);
        if ($stmt->execute()) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            echo "Une erreur est survenue lors de la suppression de l'abonnement.";
        }
    } else {
        // L'abonnement n'existe pas, vous pouvez l'ajouter
        $stmt = $mysqli->prepare("INSERT INTO abonnement (id_abonne, id_collection) VALUES (?, ?)");
        $stmt->bind_param("ii", $id_abonne, $id_collection);
        if ($stmt->execute()) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            echo "Une erreur est survenue lors de l'ajout de l'abonnement.";
        }
    }

    $stmt->close();
    $mysqli->close();
} else {
    echo "Les IDs nécessaires n'ont pas été transmis.";
}

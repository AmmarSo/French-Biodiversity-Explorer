<?php
session_start();
require_once '../config.php'; // Connexion à la base de données

if(isset($_POST['user_id'])) {
    $userId = $_POST['user_id'];

    // Récupérer le chemin de l'ancienne image
    $query = $bdd->prepare("SELECT chemin_image FROM photo_de_profil WHERE utilisateur_id = ?");
    $query->execute([$userId]);
    $result = $query->fetch();

    if($result && $result['chemin_image']) {
        // Ajouter '../' devant le chemin de l'image
        $filePath = '../' . $result['chemin_image'];

        // Supprimer l'image du dossier si elle existe
        if(file_exists($filePath)) {
            unlink($filePath);
        }

        // Mettre à jour la base de données pour refléter la suppression de l'image
        $updateQuery = $bdd->prepare("UPDATE photo_de_profil SET chemin_image = NULL WHERE utilisateur_id = ?");
        $updateQuery->execute([$userId]);

        echo "La photo de profil a été supprimée avec succès.";
    } else {
        echo "Aucune photo de profil trouvée pour cet utilisateur.";
    }
} else {
    echo "Aucun utilisateur spécifié.";
}

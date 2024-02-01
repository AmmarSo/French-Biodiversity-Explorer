<?php
session_start();
require_once '../config.php'; // Connexion à la base de données

if(isset($_POST['user_id']) && isset($_FILES['avatar_file'])) {
    $userId = $_POST['user_id'];
    $image = $_FILES['avatar_file'];

    // Récupérer l'extension du fichier original
    $imageFileType = strtolower(pathinfo($image["name"], PATHINFO_EXTENSION));

    // Définir le nouveau nom de fichier - ici, nous utilisons l'ID de l'utilisateur
    $newFileName = $userId . '.' . $imageFileType;

    // Emplacement de sauvegarde des images de profil
    $target_directory = "../Ressources/profil/";
    $img_directory = "Ressources/profil/";
    $target_file = $target_directory . $newFileName; 
    $target_file1 = $img_directory . $newFileName; 
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Vérifier si le fichier est une image
    $check = getimagesize($image["tmp_name"]);
    if($check !== false) {
        echo "Le fichier est une image - " . $check["mime"] . ".";
    } else {
        echo "Le fichier n'est pas une image.";
        $uploadOk = 0;
    }

    // Vérifier si le fichier existe déjà
    if (file_exists($target_file)) {
        echo "Désolé, le fichier existe déjà.";
        $uploadOk = 0;
    }

    // Vérifier la taille de l'image (exemple : 5MB maximum)
    if ($image["size"] > 5000000) {
        echo "Désolé, votre fichier est trop volumineux.";
        $uploadOk = 0;
    }

    // Vérifier les formats autorisés
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Désolé, seuls les fichiers JPG, JPEG, PNG & GIF sont autorisés.";
        $uploadOk = 0;
    }

    // Vérifier si $uploadOk est mis à 0 par une erreur
if ($uploadOk == 0) {
    echo "Désolé, votre fichier n'a pas été téléchargé.";
    } else {
    // Si tout est ok, essayer de télécharger le fichier
    if (move_uploaded_file($image["tmp_name"], $target_file)) {
    echo "Le fichier ". htmlspecialchars(basename($image["name"])) . " a été téléchargé.";
            // Vérifier si une entrée existe déjà pour cet utilisateur
            $checkQuery = $bdd->prepare("SELECT * FROM photo_de_profil WHERE utilisateur_id = ?");
            $checkQuery->execute([$userId]);
    
            if ($checkQuery->rowCount() > 0) {
                // Mise à jour de l'entrée existante
                $updateQuery = $bdd->prepare("UPDATE photo_de_profil SET chemin_image = ? WHERE utilisateur_id = ?");
                $updateQuery->execute([$target_file1, $userId]);
                echo "Image de profil mise à jour.";
            } else {
                // Insertion d'une nouvelle entrée
                $insertQuery = $bdd->prepare("INSERT INTO photo_de_profil (utilisateur_id, chemin_image) VALUES (?, ?)");
                $insertQuery->execute([$userId, $target_file1]);
                echo "Image de profil ajoutée.";
            }
    
        } else {
            echo "Désolé, une erreur est survenue lors du téléchargement de votre fichier.";
        }
    }
} else {
    echo "Aucun fichier ou utilisateur n'a été spécifié.";
    }
    
<?php 
session_start();
require_once 'config.php'; // ajout connexion bdd 

// Vérifiez si l'utilisateur est connecté
if(!isset($_SESSION['user'])){
    header('Location:index.php');
    die();
}

// Vérifiez si le formulaire a été soumis
if(isset($_POST['new_password']) && isset($_POST['current_password']) && isset($_POST['new_password_retype'])) {
    $new_pwd = $_POST['new_password'];
    $new_pwd_retype = $_POST['new_password_retype'];
    $current_pwd = $_POST['current_password'];

    // Récupérer les informations de l'utilisateur
    $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE token = ?');
    $req->execute([$_SESSION['user']]);
    $data = $req->fetch();

    // Vérifiez si le mot de passe actuel est correct
    if(password_verify($current_pwd, $data['password'])) {
        // Vérifiez si le nouveau mot de passe et sa répétition correspondent
        if($new_pwd === $new_pwd_retype) {
            // Hasher le nouveau mot de passe
            $new_pwd_hashed = password_hash($new_pwd, PASSWORD_DEFAULT);

            // Mettre à jour le mot de passe dans la base de données
            $update = $bdd->prepare('UPDATE utilisateurs SET password = ? WHERE token = ?');
            $update->execute([$new_pwd_hashed, $_SESSION['user']]);

            // Redirection avec message de succès
            header('Location: mes_infos.php?success_password=1');
            die();
        } else {
            // Les mots de passe ne correspondent pas
            header('Location: mes_infos.php?err=new_password_mismatch');
            die();
        }
    } else {
        // Mauvais mot de passe actuel
        header('Location: mes_infos.php?err=current_password');
        die();
    }
} else {
    // Redirection si le formulaire n'est pas soumis
    header('Location: mes_infos.php');
    die();
}
?>

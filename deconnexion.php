<?php 
    session_start();
    session_destroy(); // Détruire la session
    setcookie(session_name(), "", time() - 3600); // Supprimer le cookie de session
    header('Location: index.php'); // Rediriger vers la page d'accueil
    die();


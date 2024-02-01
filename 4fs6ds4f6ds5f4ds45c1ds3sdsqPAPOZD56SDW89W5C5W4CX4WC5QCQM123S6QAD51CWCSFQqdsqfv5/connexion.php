<?php
session_start(); // Démarrage de la session
require_once 'config.php'; // On inclut la connexion à la base de données

if (!empty($_POST['email']) && !empty($_POST['password'])) // Si il existe les champs email, password et qu'ils ne sont pas vides
{
    // Patch XSS
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $email = strtolower($email); // email transformé en minuscule

    // On regarde si l'utilisateur est inscrit dans la table administrateur
    $check = $bdd->prepare('SELECT id, pseudo, email, password, token, ip FROM administrateur WHERE email = ?');
    $check->execute(array($email));
    $data = $check->fetch();
    $row = $check->rowCount();

    // Si > à 0 alors l'utilisateur existe
    if ($row > 0)
    {
        // Vérification de l'adresse IP
        $userIP = $_SERVER['REMOTE_ADDR'];
        $allowedIP = $data['ip'];

        if ($userIP === $allowedIP) // Vérification de l'adresse IP
        {
            // Si le mail est bon niveau format
            if (filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                // Si le mot de passe est le bon
                if (password_verify($password, $data['password']))
                {
                    // On créer la session et on redirige sur la bonne page
                    $_SESSION['user'] = $data['token'];
                    header('Location: pageprincipale.php');
                    die();
                }
                else
                {
                    header('Location: index.php?login_err=password');
                    die();
                }
            }
            else
            {
                header('Location: index.php?login_err=email');
                die();
            }
        }
        else
        {
            header('Location: index.php?login_err=ip');
            die();
        }
    }
    else
    {
        header('Location: index.php?login_err=already');
        die();
    }
}
else
{
    header('Location: index.php');
    die();
} // si le formulaire est envoyé sans aucune données
?>

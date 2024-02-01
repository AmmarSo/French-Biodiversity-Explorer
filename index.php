<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Balises meta pour le jeu de caractères, le viewport et la compatibilité -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS de Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css"
        integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">

    <!-- CSS de LineIcons -->
    <link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">

    <title>French Biodiversity Explorer</title>
  <link rel="icon" href="Ressources/Images/Logo.png" type="image/x-icon">

    <!-- Lien vers le CSS personnalisé -->
    <link rel="stylesheet" href="Connexion.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">
</head>
<style>
a{
    text-decoration: none;
}
#forgot-password-link{
    text-align: center;
    margin-left: 37%;
}
:hover #forgot-password-link{
    color: #ff4a4a;
}

</style>

<body id="top">
    <div class="cont">
        <!-- Formulaire de connexion -->
        <div class="form sign-in">
            <h2>Connexion</h2>
            <form action="connexion.php" method="post"> <!-- Ajout de l'attribut action et method -->
                <label>
                    <span>Email</span>
                    <input type="email" name="email"> <!-- Ajout de l'attribut name -->
                </label>
                <label>
                    <span>Mot de Passe</span>
                    <input type="password" name="password"> <!-- Ajout de l'attribut name -->
                </label>
                <button class="submit" type="submit">Connexion</button> <!-- Changement du type en submit -->
            </form>
            <a href="#" id="forgot-password-link">Mot de passe oublié?</a>
            <form id="reset-password-form" action="send.php" method="post" style="display:none;">
                Adresse Email : <input type="email" name="email" required> <br>
            <button class="submit" type="submit" name="send">Réinitialiser le mot de passe</button>
    </form>
        </div>
    
        <div class="sub-cont">
            <div class="img">
                <div class="img-text m-up">
                    <h2>Nouveau</h2>
                    <p>Inscrivez-vous pour découvrir la biodiversité</p>
                </div>
                <div class="img-text m-in">
                    <h2>Membre de FBE</h2>
                    <p>Si vous avez déjà un compte, connectez-vous simplement. Vous nous avez manqué !</p>
                </div>
                <div class="img-btn">
                    <span class="m-up">S'inscrire</span>
                    <span class="m-in">Connexion</span>
                </div>
            </div>
            <div class="form sign-up">
                <h2>Inscription</h2>
                <form action="inscription_traitement.php" method="post"> <!-- Ajout de l'attribut action et method -->
                    <label>
                        <span>Nom</span>
                        <input type="text" name="pseudo"> <!-- Ajout de l'attribut name -->
                    </label>
                    <label>
                        <span>Email</span>
                        <input type="email" name="email"> <!-- Ajout de l'attribut name -->
                    </label>
                    <label>
                        <span>Mot de Passe</span>
                        <input type="password" name="password"> <!-- Ajout de l'attribut name -->
                    </label>
                    <label>
                        <span>Confirmer le Mot de Passe</span>
                        <input type="password" name="password_retype"> <!-- Ajout de l'attribut name -->
                    </label>
                    <button type="submit" class="submit">Inscrivez-vous maintenant</button> <!-- Modification du type de bouton -->
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="script.js"></script>
    <script>document.getElementById('forgot-password-link').addEventListener('click', function(event) {
    event.preventDefault(); // Empêche le lien de suivre son URL
    document.getElementById('reset-password-form').style.display = 'block'; // Affiche le formulaire de réinitialisation
});
</script>
</body>

</html>

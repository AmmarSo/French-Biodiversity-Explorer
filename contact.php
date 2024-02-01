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
    <link rel="stylesheet" href="style.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">

        <style>
  /* Style du conteneur du formulaire */
.contact-form-container {
    font-family: Arial, sans-serif;
    background-color: #d9f2e6; /* Vert pastel pour le fond */
    padding: 20px;
    border-radius: 10px;
    max-width: 2000px; /* Largeur maximale du formulaire */
    width: 500px;
    margin: auto;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
}

/* Style des titres */
.contact-form-container h2 {
    color: #2a624b; /* Vert foncé pour le titre */
    text-align: center;
}

/* Style des groupes de formulaire */
.form-group {
    margin-bottom: 15px;
}

/* Style des labels */
.form-group label {
    display: block;
    margin-bottom: 5px;
    color: #2a624b; /* Vert foncé pour les labels */
}

/* Style des champs de saisie et de la zone de texte */
.form-group input[type="text"],
.form-group input[type="email"],
.form-group textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #aee1cc; /* Bordure plus foncée */
    border-radius: 5px;
    box-sizing: border-box;
}

/* Style du bouton d'envoi */
.submit-btn {
    width: 100%;
    padding: 10px;
    background-color: #78c8a1; /* Vert plus foncé pour le bouton */
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

/* Hover effet pour le bouton */
.submit-btn:hover {
    background-color: #65b38a;
}
#a{
    text-align: center;
}


</style>
    </head>

<body id="top">

    <!-- Section héro avec une vidéo en arrière-plan -->
    <div class="hero" id="home">
        <video class="hero-video" autoplay loop muted poster="video-poster.jpg">
            <source src="Ressources/Images/biodiversite.mp4" type="video/mp4">
                </video>

        <!-- Barre de navigation -->
        <nav>
            <img src="Ressources/Images/Logo.png" class="logo">
            <ul class="nav-links">
                <li><a href="pageprincipale.php">Accueil</a></li>
                <li><a href="Taxons.php">Taxons</a></li>
                <li><a href="les_collections.php">Collections</a></li>
            </ul>
            <?php
            session_start();
            require_once 'config.php'; 
            if(isset($_SESSION['user'])){
                echo '<a href="mon_espace.php" class="compte-btn">Mon Espace</a>';}
            else {  
                echo '<a href="Connexion.php" class="compte-btn">Connexion</a> ';
            }   
            ?>
        </nav>
        <!-- Contenu héro avec barre de recherche et boutons -->
         <div class="contact-form-container">
    <h2 id="a">Contactez-nous</h2>
    <form id="contact-form" method="post" action="fonctions/formulaire_contact.php">
        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="subject">Sujet</label>
            <input type="text" id="subject" name="subject" required>
        </div>
        <div class="form-group">
            <label for="message">Message</label>
            <textarea id="message" name="message" rows="6" required></textarea>
        </div>
        <button type="submit" class="submit-btn">Envoyer</button>
    </form>
</div>

</br></br></br></br></br> 


    
     <!--Footer-->
     <section class="footer">
    <h4>A Propos de Nous</h4>
     <p>La biodiversité, reflet de la richesse écologique de notre planète, est une toile complexe tissée par une variété infinie de formes de vie. Protéger et préserver cette diversité biologique est non seulement un impératif environnemental, mais aussi une garantie pour notre propre survie.</p>
     <div class="icons">
     <a href="https://www.instagram.com"><i class="fab fa-instagram"></i></a>
    <a href="https://www.linkedin.com"><i class="fab fa-linkedin"></i></a>
    <a href="https://www.facebook.com"><i class="fab fa-facebook"></i></a>
    <a href="https://www.twiiter.com"><i class="fa-brands fa-x-twitter"></i></a> 

     </div>
     <P></P>
  </section>

</body>

</html>

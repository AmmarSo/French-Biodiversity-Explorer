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
    a {
        text-decoration: none;
    }
    #mon_espace{
        text-align: center;
        color: white;
        font-size: 50px;
        font-weight: bold;
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
                echo '<a href="#" class="compte-btn">Mon Espace</a>';}
            else {  
                echo '<a href="Connexion.php" class="compte-btn">Connexion</a> ';
                header('Location: index.php');
            }   
                    // si la session existe pas soit si l'on est pas connecté on redirige
        if(!isset($_SESSION['user'])){
        }
        else{
        // On récupere les données de l'utilisateur
        $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE token = ?');
        $req->execute(array($_SESSION['user']));
        $data = $req->fetch();}
            ?>
        
        </nav>
        <br/><br/><br/><br/><br/>
        <h1 id="mon_espace">Mon Espace</h1>
        <div class="icons-container">

        <!-- Conteneurs d'icônes individuels avec des titres, des descriptions et des liens "En savoir plus" -->
        <a href="mes_infos.php" target="_blank"><div class="icons">
            <img src="Ressources/Images/mes_infos.png" alt="">
            <h3>Mes Infos</h3>
            <p>Consultez les infos de votre compte et changez votre mot de passe</p>
        </div></a>

        <a href="ma_collection.php" target="_blank"><div class="icons">
            <img src="Ressources/Images/ma_collection.png" alt="">
            <h3>Ma collection</h3>
            <p>Consultez les taxons que vous avez ajouté en collection !</p>
        </div></a>

        <a href="mes_abonnements.php"><div class="icons">
            <img src="Ressources/Images/mes_abonnements.png" alt="">
            <h3>Mes abonnements</h3>
            <p>Consultez la collection des comptes auxquels vous êtes abonné !</p>
        </div>
        </a>

        <a href="amis.php"><div class="icons">
            <img src="Ressources/Images/amis.png" alt="">
            <h3>Mes Amis</h3>
            <p>Discutez avec vos amis des taxons vues sur le site</p>
        </div></a>
    </div>
    
    <br/><br/><br/><br/><br/><br/>
       

     <!--Footer-->
     <section class="footer">
    <h4>A Propos de Nous</h4>
     <p>La biodiversité, reflet de la richesse écologique de notre planète, est une toile complexe tissée par une variété infinie de formes de vie. Protéger et préserver cette diversité biologique est non seulement un impératif environnemental, mais aussi une garantie pour notre propre survie.</p>
     <div class="icons">
     <a href="https://www.instagram.com"><i class="fab fa-instagram"></i></a>
    <a href="https://www.linkedin.com"><i class="fab fa-linkedin"></i></a>
    <a href="https://www.facebook.com"><i class="fab fa-facebook"></i></a>
    <a href="https://www.twiiter.com"><i class="fa-brands fa-x-twitter"></i></a> 
    <a href="contact.php"><p>Contactez-nous !</p></a>

     </div>
     <P></P>
  </section>

</body>

</html>

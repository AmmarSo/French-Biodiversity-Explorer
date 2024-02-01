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
                <li><a href="#">Accueil</a></li>
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
        <div class="container">
            <h1>French Biodiversity Explorer</h1>
           <a href="#icons-container"> <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="white" class="bi bi-arrow-down-short" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L7.5 10.293V4.5A.5.5 0 0 1 8 4"/>
</svg></a>

        </div>
    </div>

    <!-- Section des icônes -->
    <div class="icons-container" id="icons-container">

        <!-- Conteneurs d'icônes individuels avec des titres, des descriptions et des liens "En savoir plus" -->
        <div class="icons">
            <img src="Ressources/Images/icon1.png" alt="">
            <h3>recycler</h3>
            <p>"Ensemble, engageons-nous pour un avenir durable en favorisant le recyclage et en préservant notre planète."</p>
        </div>

        <div class="icons">
            <img src="Ressources/Images/icon2.png" alt="">
            <h3>panneau solaire</h3>
            <p>Les panneaux solaires, alliés incontournables de l'énergie verte, illustrent notre engagement envers un avenir durable, où l'innovation technologique </p>
        </div>

        <div class="icons">
            <img src="Ressources/Images/icon3.png" alt="">
            <h3>économiser l'eau</h3>
            <p>"En adoptant des gestes simples tels que la réparation rapide des fuites, la collecte de l'eau de pluie....</p>
        </div>

        <div class="icons">
            <img src="Ressources/Images/icon4.png" alt="">
            <h3>éolienne</h3>
            <p>Les éoliennes, symboles de notre engagement envers une énergie propre, transforment la puissance du vent en électricité. 
                En embrassant cette technologie renouvelable</p>
        </div>

    </div>

    <!-- Section "À propos" -->
    <section class="about" id="about">

        <h1 class="heading"> <i class="fas fa-quote-left"></i> À propos De Nous <i class="fas fa-quote-right"></i> </h1>

        <div class="row">

            <div class="image">
                <img src="Ressources/Images/Animal.jpg" alt="">
            </div>

            <div class="content">
                <h3> Préservation de la Biodiversité</h3>
                <p>"Ensemble, engageons-nous pour un avenir durable en favorisant le recyclage et en préservant notre planète."</p>
                <p>la biodiversité constitue le fondement de la stabilité écologique, de la résilience des écosystèmes et de la survie même de l'humanité.

                    Chaque être vivant, qu'il s'agisse d'une petite plante, d'un insecte, d'un oiseau ou d'un mammifère, joue un rôle crucial dans le maintien de l'équilibre naturel. </p>
                    <br>
                    <br>
                <a href="#"><button class="btn btn-primary">En savoir plus</button></a>
            </div>

        </div>

        <!-- Conteneurs de boîtes avec des chiffres et des descriptions -->
        <div class="box-container">

            <div class="box">
                <i class="fas fa-users"></i>
                <h3>1000+</h3>
                <p>bénévoles</p>
            </div>

            <div class="box">
                <i class="fas fa-tree"></i>
                <h3>1300+</h3>
                <p>arbres plantés</p>
            </div>

            <div class="box">
                <i class="fas fa-paw"></i>
                <h3>450+</h3>
                <p>animaux sauvés</p>
            </div>
    </section>

    <script src="app.js"></script>

    
  <section class="explore">
    <div class="explore-col">
      <div class="line">
  <h1>Biodiversité</h1>
  <div class="line"></div>
  <p>La biodiversité, reflet de la richesse écologique de notre planète, est une toile complexe tissée par une variété infinie de formes de vie. Protéger et préserver cette diversité biologique est non seulement un impératif environnemental, mais aussi une garantie pour notre propre survie. En reconnaissant la valeur inestimable de chaque espèce et en adoptant des pratiques durables, 
    nous œuvrons à maintenir l'équilibre délicat de notre écosystème, 
    préservant ainsi la biodiversité pour les générations futures.
    &nbsp;
    &nbsp;
    <a href="#" class="btn btn-primary">En savoir plus</a>
  </p>
</div>
</div>
 </section>
 <section>
 <div class="titre">
    <h2>Les Informations</h2>
  </div>
  <section class="service-section">
    <div class="service-block">
      <img src="Ressources/Images/outre.jpg" alt="Image de service 1">
      <div class="service-block-content">
        <h3 class="service-block-title">Outre-Mer</h3>
        <p class="service-block-description">La France occupe une place unique par la variété de ses collectivités d’outre-mer et donc de ses milieux naturels.</p>
        <a href="#" class="service-block-button">Lire Plus</a>
      </div>
    </div>
    <div class="service-block">
      <img src="Ressources/Images/bio.jpg" alt="Image de service 2">
      <div class="service-block-content">
        <h3 class="service-block-title">Biodiversité</h3>
        <p class="service-block-description">La Géodiversité fait référence à l’ensemble des éléments des sous-sols, des sols et des paysages qui constituent des systèmes organisés.</p>
        <a href="#" class="service-block-button">Lire Plus</a>
      </div>
    </div>
    <div class="service-block">
      <img src="Ressources/Images/geo.jpg" alt="Image de service 3">
      <div class="service-block-content">
        <h3 class="service-block-title">Géodiversité</h3>
        <p class="service-block-description">Le concept de biodiversité fait référence à l’ensemble des composantes et des variations du monde vivant.</p>
        <a href="#" class="service-block-button">Lire Plus</a>
      </div>
    </div>
</section>
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

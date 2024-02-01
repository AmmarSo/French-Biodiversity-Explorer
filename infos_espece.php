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
   .species-container {
    width: 80%;
    margin: 0 auto;
    padding: 20px;
    background-color: #E5F5E5; /* Couleur d'arrière-plan verte */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.species-info {
    font-family: Arial, sans-serif;
    font-size: 16px;
    color: #333;
    line-height: 1.6;
    margin-top: 20px;
}

h1 {
    font-size: 28px;
    color: #4CAF50; /* Vert plus foncé pour le titre */
    margin-bottom: 10px;
}

.image-link {
    text-decoration: none;
    color: blue; /* Vert pour les liens */
}

.image-link:hover {
    text-decoration: underline;
}
.svg-container svg {
    width: 400px; /* ou toute autre taille */
    height: auto; /* pour conserver les proportions */
}
.svg-container1 svg {
    width: 150px; /* ou toute autre taille */
    height: auto; /* pour conserver les proportions */
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
        </br></br></br></br>
        <!-- Contenu héro avec barre de recherche et boutons -->
        <main>
<?php
if (isset($_GET['id'])) {
    $espece_id = $_GET['id'];
    $apiUrl = "https://taxref.mnhn.fr/api/taxa/$espece_id";
    $url_svg = "https://inpn.mnhn.fr/cartosvg/couchegeo/repartitionCommunaleAZ/$espece_id/fr_light";
    $carte_taxon = file_get_contents($url_svg);
    $jsonData = file_get_contents($apiUrl);
    $data = json_decode($jsonData, true);
    $habitatData = null;

    if (isset($data['_links']['habitat']['href'])) {
        $habitatUrl = $data['_links']['habitat']['href'];
        $habitatDataJson = file_get_contents($habitatUrl);
        $habitatData = json_decode($habitatDataJson, true);
        $url_svg = 'https://inpn.mnhn.fr/img/especes/habitat/habitat-'. $habitatData['id'] .'.svg';
        $habitat_logo = file_get_contents($url_svg);
    }

    if ($data) {
        echo '<div class="species-container">';
        echo '<h1>' . $data['frenchVernacularName'] . '</h1>';
        echo '<div class="species-info">';
        echo '<p>Vous pouvez ici voir le taxon ' . $data['frenchVernacularName'] . ' ou ' . $data['englishVernacularName'] . ' en anglais de son nom complet scientifique ' . $data['scientificName'] . ' faisant partie du royaume des ' . $data['vernacularKingdomName'] . ' et de la famille des ' . $data['familyName'];

        if ($habitatData && isset($habitatData['definition'])) {
            echo '. ' . $habitatData['definition'];
        } else {
            echo ', et il peut habiter dans plusieurs habitats.';
        }

        echo '</p>';

        // Autres informations
        echo '<p><strong>Nom scientifique:</strong> ' . $data['scientificName'] . '</p>';
        echo '<p><strong>Royaume:</strong> ' . $data['kingdomName'] . '</p>';
        echo '<p><strong>Famille:</strong> ' . $data['familyName'] . '</p>';
        echo '<p><strong>Ordre:</strong> ' . $data['orderName'] . '</p>';
        echo '<p><strong>Classe:</strong> ' . $data['className'] . '</p>';
        echo '<p><strong>Phylum:</strong> ' . $data['phylumName'] . '</p>';
        echo '<p><strong>Nom vernaculaire en anglais:</strong> ' . $data['englishVernacularName'] . '</p>';
        echo '<p><strong>Vernaculaire Order Name:</strong> ' . $data['vernacularOrderName'] . '</p>';
        echo '<p><strong>Vernaculaire Phylum Name:</strong> ' . $data['vernacularPhylumName'] . '</p>';
        $image_search_url = "https://www.google.com/search?q=Taxon " . $data['scientificName'] . "&tbm=isch";
        echo '<div class="svg-container1">' . $habitat_logo . '</div>';
        echo '<div class="svg-container">' . $carte_taxon . '</div>';

        echo '<p><a target=_blank class="image-link" href="' . $image_search_url . '">Rechercher des images de ' . $data['frenchVernacularName'] . '</a></p>';

        echo '</div>';
        echo '</div>';
    } else {
        echo "Aucune information trouvée pour cet ID de taxon.";
    }
} else {
    echo "ID de taxon non spécifié.";
}
?>
</main>
</br></br></br></br></br></br></br>

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

<?php session_start(); ?>
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
    <link rel="stylesheet" href="taxons.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">
        <style>
  .container {
    display: flex;
    flex-wrap: wrap;
    margin-right:20%;
    margin-left: 20%;
    font-size:20px;
    border:none;
  }

  .div1, .div2 {
    flex: 1;
    margin: 5px;
    border: 1px solid #000;
    display: flex; /* Utilisez la flexbox pour centrer le contenu verticalement */
    flex-direction: column; /* Alignez le contenu en colonne */
  }

  .div1 {
    max-height: 550px; /* Définissez une hauteur maximale pour la div1 et la div2 */
    padding: 10px;
    overflow: hidden;
  }

  .div2 {
    max-height: 550px; /* Définissez une hauteur maximale pour la div1 et la div2 */
  }

  .fit-picture {
    max-width: 550px; /* Assurez-vous que l'image s'adapte à la div2 */
    height: auto; /* Permettez à la hauteur de l'image de s'ajuster automatiquement */
  }

  @media (max-width: 768px) {
    .div1, .div2 {
      flex: 100%;
    }
  }

        body {
            font-family: Arial, sans-serif;
        }

        main {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 20px;
            border-radius: 80%;
        }

        label {
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .species-container {
            display: flex;
            flex-wrap: wrap;
        }

        .species {
            width: calc(33.33% - 20px); /* 3 espèces par ligne avec un peu d'espace */
            margin: 10px;
            padding: 10px;
            background-color: #C0E6C0; /* Couleur du fond blanc */
            border: 1px solid #ccc;
        }

        .species h2 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .species p {
            margin: 0;
        }
        .species {
        display: inline-block;
        width: 30%;
        margin: 10px;
        padding: 10px;
        border: 1px solid #ccc;
    }

    .first-in-row {
        clear: left;
    }
    a{
      text-decoration: none;
      color: black;
        }

    </style>
    </head>

<body id="top">

    <!-- Section héro avec une vidéo en arrière-plan -->
    <div class="hero" id="home">

        <!-- Barre de navigation -->
        <nav>
            <img src="Ressources/Images/Logo.png" class="logo">
            <ul class="nav-links">
                <li><a href="pageprincipale.php">Accueil</a></li>
                <li><a href="#">Taxons</a></li>
                <li><a href="les_collections.php">Collections</a></li>
            </ul>
            <?php
            require_once 'config.php'; 
            if(isset($_SESSION['user'])){
                echo '<a href="mon_espace.php" class="compte-btn">Mon Espace</a>';}
            else {  
                echo '<a href="Connexion.php" class="compte-btn">Connexion</a> ';
            }   
            if(!isset($_SESSION['user'])){
            }
            else{
            // On récupere les données de l'utilisateur
            $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE token = ?');
            $req->execute(array($_SESSION['user']));
            $data = $req->fetch();}
            ?>
        
        </nav>

        <!-- Contenu héro avec barre de recherche et boutons -->
<div class="container">
    <h1 id="mon_espace">Rechercher un taxon :</h1>
    <main>
    <form method="GET">
        <input type="text" id="animalName" name="animalName" placeholder="Entrez le nom de l'animal">
        <input type="submit" name="searchByName" value="Rechercher par Nom">
    </form>

    <div class="species-container">
        <?php
        if (isset($_GET['searchByName'])) {
            // Assurez-vous que le nom de l'animal est défini
            if (isset($_GET['animalName']) && !empty($_GET['animalName'])) {
                $vernacularName = $_GET['animalName'];
                $apiUrl = "https://taxref.mnhn.fr/api/taxa/search?version=16.0&frenchVernacularNames={$vernacularName}";

                // Récupérer le contenu JSON depuis l'URL
                $jsonData = file_get_contents($apiUrl);

                // Décoder le JSON en un tableau associatif
                $dataArray = json_decode($jsonData, true);

                // Vérifier si la décodification a réussi
                if ($dataArray !== null) {
                    // Vérifier si la clé _embedded existe
                    if (isset($dataArray['_embedded']) && isset($dataArray['_embedded']['taxa'])) {
                        // Parcourir le tableau des espèces et afficher les informations spécifiques
                        foreach ($dataArray['_embedded']['taxa'] as $species) {
                      echo '<a href=infos_espece.php?id=' . $species['id'] . ' target=_blank><div class="species">';
                      $frenchVernacularName = $species['frenchVernacularName'];
                      $scientificName = $species['scientificName'];
                      $kingdomName = $species['kingdomName'];
                  
                      // Afficher les informations pour chaque espèce
                      echo "<h2>Nom vernaculaire français : $frenchVernacularName</h2>";
                      echo "<p>Nom scientifique : $scientificName</p>";
                      echo "<p>Royaume : $kingdomName</p>";
                      $image_search_url = "https://www.google.com/search?q=Taxon " . $scientificName . "&tbm=isch";
                    
                      if (isset($species['_links']['media']['href'])) {
                        echo '<p><a target=_blank href="' . $image_search_url . '">🖼️ Cliquez ici pour voir des images de '.$frenchVernacularName.'</a></p>';
                      } else {
                          echo '<p><a target=_blank href="' . $image_search_url . '">🖼️ Cliquez ici pour voir des images de '.$frenchVernacularName.'</a></p>';
                      }

                      $user_id_bdd = $data['id'];
                      $specie_id_bdd = $species['id'];
                      // Vérifier si l'association utilisateur_id et taxon_id existe déjà dans la table favoris
                      $sql = "SELECT COUNT(*) AS count FROM favoris WHERE user_id = :user_id AND espece_id = :espece_id";

                      $stmt = $bdd->prepare($sql);
                      $stmt->bindParam(':user_id', $data['id'], PDO::PARAM_INT);
                      $stmt->bindParam(':espece_id', $species['id'], PDO::PARAM_STR);
                      $stmt->execute();
                      $favorite_row = $stmt->fetch(PDO::FETCH_ASSOC);

                      // Afficher le cœur en rouge si le taxon est en favori
                      $heartColor = $favorite_row['count'] > 0 ? 'red' : 'grey';
                      
                      // Ajouter un formulaire et un bouton "Ajouter au favoris"
                      echo '<form method="POST" action="fonctions/ajouter_favoris.php">';
                      echo '<input type="hidden" name="espece_id" value="' . $species['id'] . '">';
                      echo '<input type="hidden" name="user_id" value="' . $data['id'] . '">';
                      echo '<button type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="'.$heartColor.'" class="bi bi-heart-fill" viewBox="0 0 16 16">
                      <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
                    </svg></button>';
                      echo '</form>';
                  
                      echo '</div></a></p>';
                  }
                }
              } else {
                  echo "Aucun résultat trouvé pour la recherche : $vernacularName";
              }
          } else {
              // La décodification a échoué
              echo "Veuillez entrer le nom de l'animal pour effectuer une recherche.";
          }
      } else {
          echo "Veuillez entrer le nom de l'animal pour effectuer une recherche.";
      }

  ?>
</div>
</main>
</div>


    </div>

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

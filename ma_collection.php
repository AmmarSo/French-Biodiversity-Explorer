<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>French Biodiversity Explorer</title>
    <link rel="icon" href="Ressources/Images/Logo.png" type="image/x-icon">
    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    />
    <!-- CSS -->
    <link rel="stylesheet" href="Profil.css" />
    <style>
  /* Styles existants... */

  .species-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-evenly; /* Assure une répartition uniforme */
    padding: 20px; /* Ajoute un peu d'espace autour des cartes */
    background-color: #f2f2f2; /* Couleur de fond légère pour la zone de collection */
  }

  .species-card {
    flex-basis: calc(33.33% - 40px); /* Ajuste la largeur des cartes */
    margin: 10px; /* Espacement entre les cartes */
    border: 1px solid #ddd; /* Bordure plus subtile */
    border-radius: 10px; /* Coins arrondis */
    background-color: #fff; /* Fond blanc pour chaque carte */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Ombre légère pour la profondeur */
    overflow: hidden; /* Assure que tout le contenu reste dans la carte */
  }

  .species-card img {
    width: 100%; /* Permet à l'image de couvrir toute la largeur de la carte */
    height: auto;
    border-bottom: 1px solid #ddd; /* Ligne séparatrice entre l'image et le texte */
  }

  .species-info {
    padding: 10px; /* Espace intérieur pour le texte */
  }

  .species-info h3 {
    margin-top: 0;
    color: #228b22; /* Couleur du titre pour correspondre au thème de la biodiversité */
    font-size: 1.2em; /* Taille légèrement plus grande pour le titre */
  }

  .species-info p {
    margin: 5px 0; /* Réduit l'espace autour des paragraphes */
    font-size: 0.9em; /* Taille de police plus petite pour les détails */
  }

  a {
    color: #006400; /* Couleur des liens en accord avec le thème */
    text-decoration: none; /* Supprime le soulignement des liens */
  }

  a:hover {
    text-decoration: none; /* Souligne les liens au survol */
  }

  .custom-h1 {
    font-family: 'Arial', sans-serif;
    color: #228b22;
    text-align: center;
    font-size: 40px;
    margin-top: 20px;
    margin-bottom: 20px;
    text-shadow: 1px 1px 2px #000000;
  }
</style>
  </head>
  <body>
  <?php
    session_start();
    if(isset($_SESSION['user'])){
    }
    else { 
        header('Location: index.php');
    }
    require_once 'config.php';
    if(!isset($_SESSION['user'])){
        echo '<a class="logout-btn" id="InscriptOrConnect" href="connexion?logout=true">S\'inscrire ou se connecter</a>';
    }
    else{
    // On récupere les données de l'utilisateur
    $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE token = ?');
    $req->execute(array($_SESSION['user']));
    $data = $req->fetch();}

    // Connexion à la base de données 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test data import";

    $conn = new mysqli($servername, $username, $password, $dbname);
    $id_collection = $data['id']; 
    $name_collection = $data['pseudo'];

  
    // Vérifie la connexion
    if ($conn->connect_error) {
        die("La connexion a échoué : " . $conn->connect_error);
    }

    $sql = "SELECT COUNT(*) AS count FROM favoris WHERE user_id = $id_collection";

    $result = $conn->query($sql);

    if ($result !== false && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $count = $row["count"];
        }
    } else {
        ///echo "Aucun résultat trouvé. Cet utilisateur n'a pas de taxons enregistrés.";
    }

    $sql = "SELECT espece_id FROM favoris WHERE user_id = $id_collection";

    $result = $conn->query($sql);

    if ($result !== false && $result->num_rows > 0) {
        $espece_ids = array();
    }

    // Assurez-vous que $id_collection est défini et sécurisé
  if(isset($data['id'])) {
      $id_collection = $conn->real_escape_string($data['id']);
      // Récupérer le chemin de l'image de profil en fonction de $id_collection
      $sql = "SELECT chemin_image FROM photo_de_profil WHERE utilisateur_id = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $id_collection); // "i" pour integer
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $cheminImageProfil = $row['chemin_image']; // chemin de l'image de profil
      } else {
          $cheminImageProfil = "Ressources\profil\Default.png"; // Chemin vers une image par défaut
      }
    } else {
      // Gérer le cas où $id_collection n'est pas défini
      $cheminImageProfil = "Ressources\profil\Default.png"; // Chemin vers une image par défaut
      // Ou rediriger l'utilisateur, afficher un message, etc.
      }
      
      ?>
    <?php 
    ///Abonnées
        $requête_compte = "SELECT COUNT(*) AS count FROM abonnement WHERE id_collection = $id_collection";

        $result = $conn->query($requête_compte);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $nbAbonne = $row["count"];

                // Afficher "Abonné" ou "Abonnés" en fonction du nombre d'abonnés
                $abonneText = ($nbAbonne == 1 or $nbAbonne == 0) ? 'Abonné' : 'Abonnés';
            }
        } else {
            $nbAbonne = 0;
            $abonneText = 'Abonné';

        }
        //Abonnement
        $requête_compte = "SELECT COUNT(*) AS count FROM abonnement WHERE id_abonne = $id_collection";

        $result = $conn->query($requête_compte);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $nbAbonnement = $row["count"];

                // Afficher "Abonné" ou "Abonnés" en fonction du nombre d'abonnés
                $AbonnementText = ($nbAbonnement == 1 or $nbAbonnement == 0) ? 'Abonnement' : 'Abonnements';
            }
        } else {
            $nbAbonnement = 0;
            $AbonnementText = 'Abonnement';
        }
        ?>
    <div class="header__wrapper">
      <header></header>
      <div class="cols__container">
        <div class="left__col">
          <div class="img__container"> 
          <?php echo '<img src="'.$cheminImageProfil.'" alt="Image de profil" />'; ?>
            <span></span>
          </div>
          <h2>Ma Collection<h2>
          <p>ÉcoExplorateurs Français</p>
          <ul class="about">
            <?php echo '<li><span>'.$nbAbonne.'</span>'. $abonneText .'</li>'; ?>
            <?php echo '<li><span>'.$nbAbonnement.'</span>'. $AbonnementText.'</li>'; ?>
            <?php echo '<li><span>'. $count .'</span>Collections</li>'; ?>
          </ul>

          <div class="content">
            <p>
                Ensemble, célébrons la splendeur infinie de la biodiversité qui embellit notre monde, et engageons-nous passionnément à la protéger pour les générations futures."
            </p>

            <ul>
              <li><i class="fab fa-twitter"></i></li>
              <i class="fab fa-pinterest"></i>
              <i class="fab fa-facebook"></i>
              <i class="fab fa-dribbble"></i>
            </ul>
          </div>
        </div>
        <div class="right__col">
          <nav>
            <ul>
              <li><a href="">Collection</a></li>
            </ul>
            <?php 
            // si la session existe pas soit si l'on est pas connecté on redirige
            if(!isset($_SESSION['user'])){
            }
            else{
            // On récupere les données de l'utilisateur
            $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE token = ?');
            $req->execute(array($_SESSION['user']));
            $data = $req->fetch();}

            echo '<form action="subscribe.php" method="post" class="user-collection">
        <input type="hidden" name="id_abonne" value="'.$data['id'].'">
        <input type="hidden" name="id_collection" value="'. $id_collection .'">
        <input type="submit" value="S\'abonner" class="subscribe-button">
      </form>';
?>
          </nav>

          <div class="species-container">
            <?php
            $sql = "SELECT espece_id FROM favoris WHERE user_id = $id_collection";

            $result = $conn->query($sql);
        
            if ($result !== false && $result->num_rows > 0) {
                $espece_ids = array();
                while ($row = $result->fetch_assoc()) {
                    $espece_ids[] = $row["espece_id"]; // Ajoutez l'ID de l'espèce au tableau
                }
                foreach ($espece_ids as $espece_id) {
                    $apiUrl = "https://taxref.mnhn.fr/api/taxa/$espece_id";
                    $jsonData = file_get_contents($apiUrl);
                    $data = json_decode($jsonData, true);
        
                    if ($data !== null) {
                        echo '<a href=infos_espece.php?id=' . $data['id'] . ' target=_blank><div class="species-card">';
                        echo '<div class="species-info">';
                        echo '<h3>' . $data['frenchVernacularName'] . '</h3>';
                        echo '<p><strong>Nom scientifique:</strong> ' . $data['scientificName'] . '</p>';
                        echo '<p><strong>Royaume:</strong> ' . $data['kingdomName'] . '</p>';
                        $image_search_url = "https://www.google.com/search?q=Taxon " . $data['scientificName'] . "&tbm=isch";
                        if (isset($species['_links']['media']['href'])) {
                            echo '<p><a target=_blank href="' . $image_search_url . '">🖼️ Cliquez ici pour voir des images de ' . $data['frenchVernacularName'] . '</a></p>';
                        } else {
                            echo '<p><a target=_blank href="' . $image_search_url . '">🖼️ Cliquez ici pour voir des images de ' . $data['frenchVernacularName'] . '</a></p>';
                        }
                        echo '</div>';
                        echo '</div>';
                    } else {
                        echo '<div class="species-card error">';
                        echo '<p>Aucune information trouvée pour cet espèce ID : ' . $espece_id . '</p>';
                        echo '</div></a>';
                    }
                }
                echo '</div></a>';
            } else {
                echo "Aucun taxon enregistré dans la collection.";
            }
        
            // Fermeture de la connexion à la base de données
            $conn->close();
            ?>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>

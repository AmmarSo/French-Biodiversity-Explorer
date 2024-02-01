<?php
if (isset($_GET['espece']) && !empty($_GET['espece'])) {
    $speciesName = $_GET['espece'];
    $apiUrl = "https://taxref.mnhn.fr/api/taxa/search?version=16.0&frenchVernacularNames={$speciesName}";

    // Fetch JSON data from the API
    $jsonData = file_get_contents($apiUrl);
    $dataArray = json_decode($jsonData, true);

    // Check if data is retrieved and process it
    if ($dataArray !== null) {
        if (isset($dataArray['_embedded']) && isset($dataArray['_embedded']['taxa'])) {
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
                      echo '<form method="POST" action="ajouter_favoris.php">';
                      echo '<input type="hidden" name="espece_id" value="' . $species['id'] . '">';
                      echo '<input type="hidden" name="user_id" value="' . $data['id'] . '">';
                      echo '<button type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="'.$heartColor.'" class="bi bi-heart-fill" viewBox="0 0 16 16">
                      <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
                    </svg></button>';
                      echo '</form>';
                  
                      echo '</div></a></p>';
                  }
        } else {
            echo "Aucun résultat trouvé pour la recherche : " . htmlspecialchars($speciesName);
        }
        } else {
        // Handle JSON decoding error
        echo "Erreur lors du traitement des données. Veuillez réessayer.";
        }
        } else {
        // Prompt user to enter a species name if the form is submitted empty
        echo "Veuillez entrer le nom d'une espèce pour effectuer une recherche.";
        }
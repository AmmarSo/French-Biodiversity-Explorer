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
                header('Location: index.php');
            }   
            ?>
        
        </nav>

        <!-- Contenu héro avec barre de recherche et boutons -->
        <div class="container">
            <h1>Mes Amis</h1>
            <main>
  <?php

require_once 'config.php';
if(!isset($_SESSION['user'])){
    echo '<a class="logout-btn" id="InscriptOrConnect" href="connexion?logout=true">S\'inscrire ou se connecter</a>';
}
else{
// On récupere les données de l'utilisateur
$req = $bdd->prepare('SELECT * FROM utilisateurs WHERE token = ?');
$req->execute(array($_SESSION['user']));
$data = $req->fetch();}
$mysqli = new mysqli("localhost", "root", "", "test data import");
  // Vérifiez si l'utilisateur est connecté
  if (isset($_SESSION['user'])) {
    $id_utilisateur_connecte = $data['id']; 

    // Connexion à la base de données 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test data import";

    // Création de la connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérification de la connexion
    if ($conn->connect_error) {
      die("Connexion échouée : " . $conn->connect_error);
    }

    // Requête sécurisée pour récupérer les utilisateurs abonnés réciproquement
    $sql = "SELECT DISTINCT LEAST(u1.id, u2.id) AS id_utilisateur1, GREATEST(u1.id, u2.id) AS id_utilisateur2, LEAST(u1.pseudo, u2.pseudo) AS utilisateur1, GREATEST(u1.pseudo, u2.pseudo) AS utilisateur2
    FROM abonnement a1
    JOIN abonnement a2 ON a1.id_collection = a2.id_abonne AND a1.id_abonne = a2.id_collection AND a1.id < a2.id
    JOIN utilisateurs u1 ON a1.id_abonne = u1.id
    JOIN utilisateurs u2 ON a2.id_abonne = u2.id
    WHERE (u1.id = $id_utilisateur_connecte OR u2.id = $id_utilisateur_connecte)
    AND (u1.id != u2.id)";

      // Assurez-vous que $id_collection est défini et sécurisé
  if(isset($row["utilisateur2"])) {
    $id_collection = $conn->real_escape_string($row["utilisateur2"]);
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


     // Collection user 1
  if(isset($row["utilisateur1"])) {
    $id_collection = $conn->real_escape_string($row["utilisateur1"]);
    // Récupérer le chemin de l'image de profil en fonction de $id_collection
    $sql = "SELECT chemin_image FROM photo_de_profil WHERE utilisateur_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_collection); // "i" pour integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $cheminImageProfil1 = $row['chemin_image']; // chemin de l'image de profil
    } else {
        $cheminImageProfil1 = "Ressources\profil\Default.png"; // Chemin vers une image par défaut
    }
  } else {
    // Gérer le cas où $id_collection n'est pas défini
    $cheminImageProfil1 = "Ressources\profil\Default.png"; // Chemin vers une image par défaut
    // Ou rediriger l'utilisateur, afficher un message, etc.
    }
    

    $result = $conn->query($sql);
    echo '<div class="icons-container">';
    if ($result) {
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          if ($row["utilisateur1"] !== $data['pseudo']) {
          ?>
            <!-- Conteneurs d'icônes individuels avec des titres, des descriptions et des liens "En savoir plus" -->
        <div class="icons">
            <img src="<?php echo $cheminImageProfil1?>" alt="">
            <h3>Utilisateur réciproque : <?php echo $row["utilisateur1"]; ?></h3>
            <p><form class="chat-form" action="chat.php" method="post">
                <input type="hidden" name="id_utilisateur" value="<?php echo $row["id_utilisateur1"]; ?>">
                <input type="submit" class="chat-button" value="Chatter">
              </form></p>
        </div>
          <?php
          } elseif ($row["utilisateur2"] !== $data['pseudo']) {
    
          ?>
          <!-- Conteneurs d'icônes individuels avec des titres, des descriptions et des liens "En savoir plus" -->
        <div class="icons">
            <img src="<?php echo $cheminImageProfil?>" alt="">
            <h3>Utilisateur réciproque : <?php echo $row["utilisateur2"]; ?></h3>
            <p><form class="chat-form" action="chat.php" method="post">
                <input type="hidden" name="id_utilisateur" value="<?php echo $row["id_utilisateur2"]; ?>">
                <input type="submit" class="chat-button" value="Chatter">
              </form></p>
        </div>
            
          <?php
          }
        }
      } else {
        echo "Aucun utilisateur abonné réciproquement trouvé.";
      }
    } else {
      echo "Erreur dans la requête : " . $conn->error;
    }

    $conn->close();
  } else {
    echo "Utilisateur non connecté.";
  }
  ?>
  </div>
</main>

</br></br></br></br></br><br/><br/>
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

     </div>
     <P></P>
  </section>

</body>

</html>

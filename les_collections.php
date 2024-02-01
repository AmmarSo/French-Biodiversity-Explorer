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
<style>
    .row {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .user-card {
        width: 30%;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        margin: 10px;
        box-shadow: 2px 2px 5px #888888;
    }

    .user-name {
        font-size: 20px;
        font-weight: bold;
        color: #333;
        margin-bottom: 10px;
    }

    .user-collection {
      font-size: 20px;
        font-weight: bold;
        text-align: center;
        color: green;
        margin-bottom: 10px;
    }
    .user-image{
        font-size: 20px;
        font-weight: bold;
        text-align: center;
        color: green;
        margin-bottom: 5px;
    }

    form {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    button {
        background-color: green;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
    }

    button:hover {
        background-color: darkgreen;
    }
    #mon_espace{
        text-align: center;
        color: white;
        font-size: 50px;
        font-weight: bold;
    }

</style>

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
                <li><a href="#">Collections</a></li>
            </ul>
            <?php
            session_start();
            if(isset($_SESSION['user'])){
                echo '<a href="mon_espace.php" class="compte-btn">Mon Espace</a>';}
            else {  
                echo '<a href="Connexion.php" class="compte-btn">Connexion</a> ';
                header('Location: index.php');
            }   
            require_once 'config.php'; 
            $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE token = ?');
            $req->execute(array($_SESSION['user']));
            $data = $req->fetch();
            ?>
        
        </nav>
        <br/><br/>
        <h1 id="mon_espace">Les collections</h1>
        <main>
    <?php
    $mysqli = new mysqli("localhost", "root", "", "test data import");

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test data import";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($mysqli->connect_error) {
        die("La connexion à la base de données a échoué : " . $mysqli->connect_error);
    }

    $sql = "SELECT id, pseudo FROM utilisateurs";
    $stmt = $mysqli->prepare($sql);

    if ($stmt === false) {
        die("Erreur lors de la préparation de la requête : " . $mysqli->error);
    }

    $stmt->execute();
    $stmt->bind_result($id, $pseudo);

    $count = 0; // Pour compter les utilisateurs et diviser en rangées
    echo '<div class="row">'; // Ouvrir la première rangée

    while ($stmt->fetch()) {
        if ($count % 3 == 0 && $count > 0) {
            // Fermer la rangée précédente et ouvrir une nouvelle rangée
            echo '</div><div class="row">';
        }
        $requête_compte = "SELECT COUNT(*) AS count FROM abonnement WHERE id_collection = $id";

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

        // Afficher la carte stylée pour chaque utilisateur
        echo '<div class="user-card">
                <div class="user-image"><svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
              </svg>
              </div>
              <div class="user-collection">Collection de ' . $pseudo . '</div>
              <form action="subscribe.php" method="post">
              <input type="hidden" name="id_abonne" value="'.$data['id'].'">
              <input type="hidden" name="id_collection" value="'. $id .'">
              <button type="submit">S\'abonner</button>
          </form>
          <div class="user-collection">'. $nbAbonne . ' ' . $abonneText . '</div>
          <form action="collection_utilisateur.php" target="_blank" method="post">
              <input type="hidden" name="id_collection" value="'. $id .'">
              <input type="hidden" name="name_collection" value="'. $pseudo .'">
              <button type="submit">Voir la collection !</button>
          </form>
            </div>';

        $count++;
    }

    echo '</div>'; // Fermer la dernière rangée

    $stmt->close();
    $mysqli->close();
    ?>
</main>
    
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

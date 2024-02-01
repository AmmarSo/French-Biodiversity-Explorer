<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>French Biodiversity Explorer</title>
  <link rel="icon" href="Ressources/Images/Logo.png" type="image/x-icon">
  <link rel="stylesheet" href="Ressources/style.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&family=Roboto+Flex:opsz,wght@8..144,100;8..144,300;8..144,500;8..144,700;8..144,900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="styles_form.css">
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
    display: flex; 
    flex-direction: column; 
  }

  .div1 {
    max-height: 550px; 
    padding: 10px;
    overflow: hidden;
  }

  .div2 {
    max-height: 550px; 
  }

  .fit-picture {
    max-width: 550px; 
    height: auto; 
  }

  @media (max-width: 768px) {
    .div1, .div2 {
      flex: 100%;
    }
  }
 
  form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f2f2f2;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Style pour les étiquettes */
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        /* Style pour les champs de texte et les boutons */
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        /* Style pour les boutons de soumission */
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Style pour les messages d'erreur */
        .error-message {
            color: red;
            margin-top: 5px;
        }

        /* Style pour les messages de succès */
        .success-message {
            color: green;
            margin-top: 5px;
        }
        h2, li{
          text-align: center;

        }
</style>


</head>
<nav>
  <a href="#" class="nav-icon" aria-label="homepage" aria-current="page">
    <img src="ressources/Images/Logo.png" alt="logo" />
    <span>French Biodiversity Explorer</span>
  </a>

  <div class="lienprincipals_nav">
    <button type="button" class="hamburger"  aria-label="Toggle Navigation" aria-expanded="false">
      <span></span>
      <span></span>
      <span></span>
    </button>
    <div class="liens_nav_containers">
      <a href="pageprincipale.php" aria-current="page">Administration</a>
      <a href="#" aria-current="page">Historique Action</a>
      <a href="Perf.php" aria-current="page">Suivi Performance BDD</a>
      <a href="Signalement.php" aria-current="page">Signalement</a>
    </div>
  </div>

  <div class="nav_identification">
    <?php
    session_start();
    require_once 'config.php'; // ajout connexion bdd 

    // Si la session n'existe pas, c'est-à-dire si l'administrateur n'est pas connecté, on redirige vers la page de connexion
    if(!isset($_SESSION['user'])){
        header('Location: connexion.php'); // Remplacez 'connexion.php' par le chemin de votre page de connexion
        exit; // Assurez-vous d'arrêter l'exécution du script après la redirection
    }
    else {
        // On récupère les données de l'administrateur
        $req = $bdd->prepare('SELECT * FROM administrateur WHERE token = ?');
        $req->execute(array($_SESSION['user']));
        $data = $req->fetch();
        echo '<div class="user-info">Bienvenue, ' . $data['pseudo'] . '</div> </br>';
        echo '<a class="logout-btn" href="deconnexion.php">Déconnexion</a>';
    }
    ?>
</div>

    
</nav>
<body>
    </br></br></br></br></br></br></br>

    <?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test data import";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}

// Requête pour récupérer les données de la table history_change avec les pseudos des utilisateurs
$sql = "SELECT hc.*, u.pseudo FROM history_change hc
        LEFT JOIN utilisateurs u ON hc.user_id = u.id
        ORDER BY hc.change_timestamp DESC";

$result = $conn->query($sql);

// Style du tableau
echo "<style>
table {
    width: 100%;
    border-collapse: collapse;
}
table, th, td {
    border: 1px solid black;
}
th, td {
    padding: 8px;
    text-align: left;
}
th {
    background-color: #f2f2f2;
}
tr:nth-child(even) {background-color: #f9f9f9;}
</style>";

// Vérification si la requête retourne des résultats
if ($result->num_rows > 0) {
    // Début du tableau pour afficher les résultats
    echo "<table><tr><th>ID</th><th>Table Name</th><th>Record ID</th><th>Action</th><th>User</th><th>Timestamp</th></tr>";

    // Affichage de chaque ligne de résultat
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["id"]. "</td><td>" . $row["table_name"]. "</td><td>" . $row["record_id"]. "</td><td>" . $row["action"]. "</td><td>" . $row["pseudo"] . " (" . $row["user_id"] . ")" . "</td><td>" . $row["change_timestamp"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 résultats";
}

// Fermer la connexion
$conn->close();
?>





<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>

<script src="Ressources/script.js"></script>

<footer>
  <div class="footer-content">
    <h3>French Biodiversity Explorer</h3>
    <ul class="socials">
      <li><a href="#"><i class="fa fa-facebook"></i></a></li>
      <li><a href="#"><i class="fa fa-twitter"></i></a></li>
      <li><a href="#"><i class="fa fa-instagram"></i></a></li>
      <li><a href="#"><i class="fa fa-youtube"></i></a></li>
      <li><a href="#"><i class="fa fa-linkedin-square"></i></a></li>
    </ul>
  </div>
  <div class="footer-bottom">
    <p>copyright 2023 &copy; <a href="#">French Biodiversity Explorer</a>  </p>
  </div>
</footer>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const loginBtn = document.querySelector(".login-btn");
    const modal = document.querySelector(".modal");

    loginBtn.addEventListener("click", function () {
      modal.style.display = "block";
    });
  });
</script>

</body>
</html>
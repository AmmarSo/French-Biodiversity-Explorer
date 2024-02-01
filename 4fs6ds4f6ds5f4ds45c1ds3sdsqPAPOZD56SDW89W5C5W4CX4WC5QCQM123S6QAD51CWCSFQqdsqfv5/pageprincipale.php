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
      <a href="#" aria-current="page">Administration</a>
      <a href="Historique.php" aria-current="page">Historique Action</a>
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

// Ajouter un nouvel utilisateur
if (isset($_POST['ajouter_utilisateur'])) {
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "INSERT INTO utilisateurs (pseudo, email, password) VALUES ('$pseudo', '$email', '$password')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Utilisateur ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout de l'utilisateur : " . $conn->error;
    }
}

// Modifier un utilisateur
if (isset($_POST['modifier_utilisateur'])) {
    $id = $_POST['id'];
    $nouveauPseudo = $_POST['nouveau_pseudo'];
    $nouvelEmail = $_POST['nouvel_email'];
    $nouveauMotDePasse = $_POST['nouveau_mot_de_passe'];

    $sql = "UPDATE utilisateurs SET pseudo='$nouveauPseudo', email='$nouvelEmail', password='$nouveauMotDePasse' WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Utilisateur modifié avec succès.";
    } else {
        echo "Erreur lors de la modification de l'utilisateur : " . $conn->error;
    }
}

// Supprimer un utilisateur
if (isset($_POST['supprimer_utilisateur'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM utilisateurs WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Utilisateur supprimé avec succès.";
    } else {
        echo "Erreur lors de la suppression de l'utilisateur : " . $conn->error;
    }
}

// Récupérer la liste des utilisateurs
$sql = "SELECT * FROM utilisateurs ORDER BY date_inscription DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Liste des utilisateurs :</h2>";
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li> ID: " . $row["id"] . " - Pseudo: " . $row["pseudo"] . " - Email: " . $row["email"] . "</li>";
    }
    echo "</ul>";
} else {
    echo "Aucun utilisateur trouvé.";
}

$conn->close();
?>

<!-- Formulaire pour ajouter un utilisateur -->
<h2>Ajouter un utilisateur</h2>
<form method="post">
    <input type="text" name="pseudo" placeholder="Pseudo" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Mot de passe" required><br>
    <input type="submit" name="ajouter_utilisateur" value="Ajouter">
</form>

<!-- Formulaire pour modifier un utilisateur -->
<h2>Modifier un utilisateur</h2>
<form method="post">
    <input type="number" name="id" placeholder="ID de l'utilisateur à modifier" required><br>
    <input type="text" name="nouveau_pseudo" placeholder="Nouveau pseudo"><br>
    <input type="email" name="nouvel_email" placeholder="Nouvel email"><br>
    <input type="password" name="nouveau_mot_de_passe" placeholder="Nouveau mot de passe"><br>
    <input type="submit" name="modifier_utilisateur" value="Modifier">
</form>

<!-- Formulaire pour supprimer un utilisateur -->
<h2>Supprimer un utilisateur</h2>
<form method="post">
    <input type="number" name="id" placeholder="ID de l'utilisateur à supprimer" required><br>
    <input type="submit" name="supprimer_utilisateur" value="Supprimer">
</form>


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
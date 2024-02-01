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

    .user-card {
      background-color: #E0F2E9;
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 20px;
      width: calc(33.33% - 40px);
      margin-right: 20px;
      float: left;
      margin-bottom: 20px;
      box-sizing: border-box;
    }

    .user-card h2 {
      color: #333;
    }

    .chat-form {
      margin-top: 10px;
    }

    .chat-button {
  background-color: #4CAF50;
  color: white;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  border-radius: 5px;
  cursor: pointer;
  transition: transform 0.3s, color 0.3s, background-color 0.3s;
}

.chat-button:hover {
  background-color: #45a049;
  color: #f1f1f1;
  transform: scale(1.1); 
}
main {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 70vh;
    margin-bottom: 25px;
 
}

#messages {
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 10px;
    max-width: 1000px;
    width: 80%;
    background-color: #f0f7f7;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

#messages .message {
    margin: 5px;
    padding: 8px 12px;
    border-radius: 10px;
    word-wrap: break-word;
}

#messages .sent-by-me {
    background-color: #ccffcc;
    align-self: flex-end;
    text-align: right;
}

#messages .sent-by-others {
    background-color: #e6e6e6;
    align-self: flex-start;
    text-align: left;
}

input[type="text"] {
    width: 60%;
    padding: 10px;
    margin-right: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

button[type="submit"] {
    background-color: #88cc88;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}
h2.chat-heading {
  color: #4CAF50; 
        font-size: 24px; 
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
            require_once 'config.php'; 
            if(isset($_SESSION['user'])){
                echo '<a href="mon_espace.php" class="compte-btn">Mon Espace</a>';}
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
        <main>
    <?php
    if (isset($_SESSION['user'])) {
        // Connexion à la base de données
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "test data import";
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connexion échouée : " . $conn->connect_error);
        }

        // Récupérer l'ID de l'utilisateur connecté
        $id_utilisateur_session = $data['id'];

        // Récupérer l'ID de l'ami avec lequel l'utilisateur veut chatter (supposons que vous avez l'ID de l'ami dans $id_ami)
        if (isset($_POST['id_utilisateur'])) {
            $id_ami = $_POST['id_utilisateur'];
        }
        if (isset($_POST['id_utilisateur'])) {
          $_SESSION['id_utilisateur'] = $_POST['id_utilisateur'];
      }
      if (isset($_SESSION['id_utilisateur'])) {
        $id_ami = $_SESSION['id_utilisateur'];
    }
    } else {
        echo "Utilisateur non connecté.";
    }
    ?>

<?php
    if (isset($id_ami)) {
        // Requête pour récupérer le pseudonyme de l'ami
        $query = "SELECT pseudo FROM utilisateurs WHERE id = $id_ami";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $pseudo_ami = $row['pseudo'];
        } else {
            $pseudo_ami = "Utilisateur inconnu";
        }
    }
    ?>

      <h1 id="mon_espace"><?php echo isset($pseudo_ami) ? "Chat avec $pseudo_ami " : 'Pseudo inconnu'; ?> </h1>

    <!-- Affichage des messages -->
  </br>
  <div id="messages" style="height: 400px; overflow-y: auto;">
    <?php
    if (isset($id_ami)) {
        $sql = "SELECT * FROM chat WHERE (id_envoi = $id_utilisateur_session AND id_receveur = $id_ami) OR (id_envoi = $id_ami AND id_receveur = $id_utilisateur_session) ORDER BY date_envoi";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $message = $row['message'];
                $messageId = $row['id'];
                $isSentByUser = $row['id_envoi'] == $id_utilisateur_session;
                $messageClass = $isSentByUser ? 'sent-by-me' : 'sent-by-others';

                echo '<div class="message ' . $messageClass . '">' . $message;
                echo '<form method="post" action="fonctions/Signaler_Message.php">';
                echo '<input type="hidden" name="id_message" value="' . $messageId . '">';
                echo '<input type="hidden" name="id_utilisateur_session" value="' . $id_utilisateur_session . '">';
                echo '<button title="Signaler" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="" fill="currentColor" class="bi bi-flag-fill" viewBox="0 0 16 16">
                <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12.435 12.435 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A19.626 19.626 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a19.587 19.587 0 0 0 1.349-.476l.019-.007.004-.002h.001"/>
              </svg>
              </button>';
                echo '</form></div>';
            }
        } else {
            echo "Aucun message.";
        }
    }
    ?>
</div>


  
    <form method="post" action="fonctions/Envoi_Message.php">
    <input type="hidden" name="id_ami" value="<?php echo $id_ami ?>">
    <input type="hidden" name="id_utilisateur_session" value="<?php echo $id_utilisateur_session ?>">
    <input type="text" name="new_message" maxlength="250" placeholder="Votre message">
    <button type="submit">Envoyer</button>
</form>


</main>
    </div>
    
    <br/>
       

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

  <script>
  document.addEventListener("DOMContentLoaded", function () {
    const loginBtn = document.querySelector(".login-btn");
    const modal = document.querySelector(".modal");

    loginBtn.addEventListener("click", function () {
      modal.style.display = "block";
    });
  });


document.addEventListener("DOMContentLoaded", function() {
    const chatMessages = document.getElementById('messages');

    chatMessages.scrollTop = chatMessages.scrollHeight;
});

</script>

<script>
    // Recharge la page toutes les 15 secondes
    var intervalId = setInterval(function () {
        location.reload();
    }, 15000);

    // Désactive le rechargement quand l'utilisateur tape un message
    var messageInput = document.querySelector('input[name="new_message"]');
    var isTyping = false;

    messageInput.addEventListener('input', function () {
        isTyping = messageInput.value.length > 0;
    });


    setInterval(function () {
        if (isTyping) {
            clearInterval(intervalId); 
        } else {
            intervalId = setInterval(function () {
                location.reload();
            }, 15000);
        }
    }, 10000);
</script>

</body>

</html>

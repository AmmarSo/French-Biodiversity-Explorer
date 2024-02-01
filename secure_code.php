<?php
require_once "Connexion_oublie.php";

if (isset($_POST["verifier_code"])) {
    $userEmail = $_POST['email'];
    $enteredCode = $_POST['reset_code'];

    // Récupérer le code de réinitialisation de la base de données
    $sql = "SELECT reset_code FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userEmail);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row && $row['reset_code'] === $enteredCode) {
        // Le code est correct, rediriger vers le formulaire de réinitialisation du mot de passe
        header("Location: reset_password.php?email=" . urlencode($userEmail));
    } else {
        // Le code est incorrect, afficher un message d'erreur
        echo "<script>alert('Code de réinitialisation incorrect.');document.location.href = 'verifier_code.php';</script>";
    }
}
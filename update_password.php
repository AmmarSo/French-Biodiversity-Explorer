<?php
require_once "Connexion_oublie.php";

if (isset($_POST["reset_password"])) {
    $userEmail = $_POST['email'];
    $verificationCode = $_POST['verification_code'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Vérifiez si les deux mots de passe correspondent
    if ($newPassword !== $confirmPassword) {
        echo "<script>alert('Les mots de passe ne correspondent pas.');document.location.href = 'reset_password.php?email=" . urlencode($userEmail) . "';</script>";
        exit;
    }

    // Vérifiez le code de réinitialisation
    $sql = "SELECT reset_code FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userEmail);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row || $row['reset_code'] == $verificationCode) {
        echo "<script>alert('Code de réinitialisation incorrect.');document.location.href = 'reset_password.php?email=" . urlencode($userEmail) . "';</script>";
        exit;
    }

    // Hash du nouveau mot de passe
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Mettez à jour le mot de passe dans la base de données 'users'
    $updateSql = "UPDATE users SET password = ?, reset_code = NULL WHERE email = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ss", $hashedPassword, $userEmail);

    if ($updateStmt->execute()) {
        // Mettez à jour le mot de passe dans la base de données 'utilisateurs'
        $updateUtilisateursSql = "UPDATE utilisateurs SET password = ? WHERE email = ?";
        $updateUtilisateursStmt = $conn->prepare($updateUtilisateursSql);
        $updateUtilisateursStmt->bind_param("ss", $hashedPassword, $userEmail);

        if ($updateUtilisateursStmt->execute()) {
            // Les deux mises à jour ont réussi
            echo "<script>alert('Votre mot de passe a été réinitialisé avec succès.');document.location.href = 'index.php';</script>";
        } else {
            // Échec de la mise à jour dans 'utilisateurs'
            echo "<script>alert('Erreur lors de la réinitialisation du mot de passe dans la table utilisateurs.');document.location.href = 'reset_password.php?email=" . urlencode($userEmail) . "';</script>";
        }
    } else {
        // Échec de la mise à jour dans 'users'
        echo "<script>alert('Erreur lors de la réinitialisation du mot de passe.');document.location.href = 'reset_password.php?email=" . urlencode($userEmail) . "';</script>";
    }
} else {
    // Rediriger vers le formulaire de réinitialisation si le script est accédé sans données POST
    header("Location: reset_password.php");
    exit;
}

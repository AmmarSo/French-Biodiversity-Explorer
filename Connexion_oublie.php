<?php
$servername = "localhost"; // ou l'adresse IP du serveur de base de données
$username = "root"; // votre nom d'utilisateur pour MySQL
$password = ""; // votre mot de passe pour MySQL
$dbname = "test data import"; // le nom de votre base de données

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

echo "Connexion réussie";


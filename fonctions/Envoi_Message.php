<?php
// Start the session to access session variables
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the necessary data is present in the POST request
    if (isset($_POST['id_ami']) && isset($_POST['new_message'])) {
        // Set up database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "test data import";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind the SQL statement with placeholders
        $sql = "INSERT INTO chat (message, id_envoi, id_receveur) VALUES (?, ?, ?)";
        $statement = $conn->prepare($sql);

        // Get user and friend IDs from the session and POST data
        $id_ami = $_POST['id_ami'];
        $id_utilisateur_session = $_POST['id_utilisateur_session'];
        $new_message = $_POST['new_message'];

        // Bind parameters and execute the statement
        $statement->bind_param("sii", $new_message, $id_utilisateur_session, $id_ami);
        $statement->execute();

        // Close statement and database connection
        $statement->close();
        $conn->close();
        header("Location: ../chat.php");
        exit();
    }
}
?>

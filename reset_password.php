<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de votre mot de passe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        form {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
            text-align: center;
        }
        input[type=email], input[type=password] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #004494;
        }
    </style>
</head>
<body>
    <form action="update_password.php" method="post">
        <h2>Réinitialisation de votre mot de passe</h2>
        <label for="email">Adresse Email :</label>
        <input type="email" id="email" name="email" required><br>
        <label for="new_password">Nouveau Mot de Passe :</label>
        <input type="password" id="new_password" name="new_password" required><br>
        <label for="confirm_password">Confirmer le Mot de Passe :</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br>
        <button type="submit" name="reset_password">Réinitialiser le mot de passe</button>
    </form>
</body>
</html>

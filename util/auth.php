<?php

session_start();

include("connection.php");

// Récupérer les données du formulaire
$email = $_POST['email'];
$password_input = $_POST['password'];

// Préparer la requête
$stmt = $conn->prepare("SELECT id, email, password FROM employee WHERE email = ?");
$stmt->bind_param("s", $email);

// Exécuter la requête
$stmt->execute();

// Récupérer le résultat
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && $password_input===$user['password']) {
    $_SESSION['employe_id'] = $user['id'];
    $_SESSION['employe_email'] = $user['email'];

    echo json_encode(['success' => true, 'message' => 'Connexion réussie.']);

} else {
    // Email ou mot de passe incorrect, afficher un message d'erreur
    echo json_encode(['success' => false, 'message' => 'Email ou mot de passe incorrect.']);

}

// Fermer la connexion
$stmt->close();
$conn->close();
?>


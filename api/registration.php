<?php
session_start(); // Avvia la sessione

// Esempio di registrazione semplice con PHP
// Verifico se il form è stato inviato con il metodo POST tramite la superglobale $_SERVER
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    function redirectToSignupWithError($errorMessage)
    {
        $_SESSION['signup_error'] = $errorMessage; // Memorizza l'errore nella sessione
        header('Location: ../registration.php'); // Reindirizza alla pagina di registrazione
        exit; // Termina l'esecuzione dello script
    }

    // Recupero i dati inviati dal form
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    // Validazione dell'email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        redirectToSignupWithError("Invalid email format.");
    }

    // Validazione del campo username
    if (empty($username)) {
        redirectToSignupWithError("Username field is required.");
    }

    // Validazione della password
    if (strlen($password) < 8) {
        redirectToSignupWithError("Password must be at least 8 characters long.");
    }

    include '../includes/db.php'; // Include il file di connessione al database

    // Preparo la query per inserire l'utente nel database 
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");

    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));

    // Eseguo la query con i dati recuperati dal form
    $stmt->execute();

    // Verifico se la registrazione è riuscita controllando il numero di righe inserite
    if ($stmt->rowCount() > 0) {
        // Registrazione riuscita, reindirizzo alla pagina di login
        header('Location: ../login.php');
        exit;
    } else {
        // Registrazione fallita, reindirizzo alla pagina di registrazione con un messaggio di errore
        redirectToSignupWithError("Registration failed. Please try again.");
    }
}

<?php
session_start(); // Avvia la sessione

$username = $_SESSION['user_name'];

// Verifico se l'utente è autenticato controllando la presenza della variabile di sessione
if (!isset($username)) {
    // Se l'utente non è autenticato, reindirizzo alla pagina di login
    header('Location: login.php');
    exit;
}
?>

<h1>BENVENUTO NELLA DASHBOARD, <?php echo htmlspecialchars($username); ?>!</h1>


<a href="logout.php">Logout</a>



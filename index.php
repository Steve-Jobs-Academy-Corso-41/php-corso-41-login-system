<?php
/**
 * DASHBOARD - Pagina protetta
 * 
 * Questa pagina è accessibile solo agli utenti autenticati.
 * Se l'utente non ha una sessione attiva, viene reindirizzato alla pagina di login.
 */

// 1. Avvia la sessione (necessario per accedere a $_SESSION)
session_start();

// 2. Verifico se l'utente è autenticato controllando la variabile di sessione 'id'
//    Se non esiste, significa che l'utente non ha fatto il login
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

// 3. Includo il file di connessione al database
include 'includes/db.php';

// 4. Recupero i dati dell'utente dal database usando una prepared statement
//    IMPORTANTE: uso prepare() + execute() per prevenire attacchi SQL Injection
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute([':id' => $_SESSION['id']]);

// 5. Verifico se l'utente esiste nel database
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    // L'utente non esiste più nel database: distruggo la sessione e reindirizzo al login
    session_destroy();
    header('Location: login.php');
    exit;
}
?>

<!-- 6. Mostro i dati dell'utente nella dashboard -->
<!-- htmlspecialchars() previene attacchi XSS: converte i caratteri speciali in entità HTML -->
<h1>BENVENUTO NELLA DASHBOARD, <?php echo htmlspecialchars($user['username']); ?>!</h1>

<p>Email: <?php echo htmlspecialchars($user['email']); ?></p>

<a href="logout.php">Logout</a>
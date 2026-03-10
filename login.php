<?php
/**
 * PAGINA DI LOGIN
 * 
 * Mostra il form di login e gli eventuali messaggi di errore.
 * I dati del form vengono inviati a api/login.php tramite metodo POST.
 */

// IMPORTANTE: session_start() deve essere chiamato PRIMA di qualsiasi output HTML
// altrimenti PHP genera un warning perché i cookie di sessione vanno inviati negli header HTTP
session_start();
?>

<!-- Form di login: invia i dati a api/login.php con metodo POST -->
<form action="api/login.php" method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>

    <button type="submit">Login</button>
</form>

<?php
// Mostro l'eventuale errore di login e lo rimuovo dalla sessione
if (isset($_SESSION['login_error'])) {
    echo "<p style='color: red;'>" . htmlspecialchars($_SESSION['login_error']) . "</p>";
    unset($_SESSION['login_error']);
}
?>

<p>Non hai un account? <a href="registration.php">Registrati</a></p>
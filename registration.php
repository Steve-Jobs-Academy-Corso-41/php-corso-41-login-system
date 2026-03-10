<?php
/**
 * PAGINA DI REGISTRAZIONE
 * 
 * Mostra il form di registrazione e gli eventuali messaggi di errore.
 * I dati del form vengono inviati a api/registration.php tramite metodo POST.
 */

// IMPORTANTE: session_start() PRIMA di qualsiasi output HTML
session_start();
?>

<!-- Form di registrazione: invia i dati a api/registration.php con metodo POST -->
<form action="api/registration.php" method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>

    <button type="submit">Sign Up</button>
</form>

<?php
// Mostro l'eventuale errore di registrazione e lo rimuovo dalla sessione
if (isset($_SESSION['signup_error'])) {
    echo "<p style='color: red;'>" . htmlspecialchars($_SESSION['signup_error']) . "</p>";
    unset($_SESSION['signup_error']);
}
?>

<p>Hai già un account? <a href="login.php">Accedi</a></p>
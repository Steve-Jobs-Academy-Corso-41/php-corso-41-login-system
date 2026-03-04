<!-- Form di login semplice in HTML -->
<form action="api/login.php" method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>

    <button type="submit">Login</button>
</form>

<?php
session_start(); // Avvia la sessione

// Mostra eventuali errori di login
if (isset($_SESSION['login_error'])) {
    // Mostra l'errore e poi rimuovilo dalla sessione
    echo "<p style='color: red;'>" . $_SESSION['login_error'] . "</p>";
    unset($_SESSION['login_error']); // Rimuove l'errore dopo averlo mostrato
}
?>
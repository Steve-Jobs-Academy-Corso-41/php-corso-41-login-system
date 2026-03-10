<?php
/**
 * LOGOUT
 * 
 * Distrugge la sessione dell'utente e reindirizza alla pagina di login.
 */

// 1. Avvio la sessione (necessario per poterla poi distruggere)
//    NOTA: session_start() è obbligatorio anche per distruggere una sessione!
session_start();

// 2. Rimuovo tutte le variabili di sessione (es. $_SESSION['id'])
session_unset();

// 3. Distruggo la sessione sul server
session_destroy();

// 4. Reindirizzo alla pagina di login
header('Location: login.php');
exit;

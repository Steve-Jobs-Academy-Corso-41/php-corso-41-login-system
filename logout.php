<?php
unset($_SESSION['user_name']); // Rimuove la variabile di sessione che contiene il nome dell'utente

session_unset(); // Rimuove tutte le variabili di sessione
session_destroy(); // Distrugge la sessione


header('Location: login.php'); // Reindirizza alla pagina di login
exit;

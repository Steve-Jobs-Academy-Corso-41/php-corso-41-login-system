<?php
/**
 * CONNESSIONE AL DATABASE
 * 
 * Questo file crea una connessione al database MySQL usando PDO.
 * Viene incluso (con 'include') in tutti i file che necessitano accesso al database.
 * 
 * PDO (PHP Data Objects) è un'interfaccia per accedere ai database in PHP.
 * Supporta prepared statements, che prevengono attacchi SQL Injection.
 */

// Parametri di connessione al database
$host = 'localhost';       // Indirizzo del server MySQL
$dbname = 'php-corso-41';  // Nome del database
$username = 'root';        // Username MySQL (default in XAMPP)
$password = '';            // Password MySQL (vuota in XAMPP)

try {
    // Creo una nuova connessione PDO al database MySQL
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Imposto la modalità di errore su EXCEPTION:
    // in caso di errore SQL, PHP lancerà un'eccezione (PDOException)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Se la connessione fallisce, mostro l'errore e interrompo l'esecuzione
    die("Connessione al database fallita: " . $e->getMessage());
}

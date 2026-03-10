<?php
/**
 * API LOGIN
 * 
 * Gestisce la logica di autenticazione:
 * 1. Riceve email e password dal form (metodo POST)
 * 2. Valida i dati ricevuti
 * 3. Cerca l'utente nel database
 * 4. Verifica la password con password_verify()
 * 5. Se tutto OK, salva l'ID utente in sessione e reindirizza alla dashboard
 */

session_start();

// Verifico che la richiesta sia di tipo POST (il form è stato inviato)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /**
     * Funzione helper: reindirizza al login mostrando un messaggio di errore.
     * L'errore viene salvato nella sessione così sopravvive al redirect.
     */
    function redirectToLoginWithError($errorMessage)
    {
        $_SESSION['login_error'] = $errorMessage;
        header('Location: ../login.php');
        exit;
    }

    // -- STEP 1: Recupero i dati inviati dal form --
    // NOTA: NON uso htmlspecialchars() qui perché:
    // - htmlspecialchars() serve per l'OUTPUT (prevenire XSS quando mostro dati in HTML)
    // - Per l'INPUT uso trim() per rimuovere spazi e poi valido/sanitizzo
    // - Se usassi htmlspecialchars() sulla password, caratteri come & o < verrebbero
    //   trasformati in &amp; o &lt; e password_verify() fallirebbe!
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // -- STEP 2: Validazione dei dati --

    // Verifico che l'email sia valida con filter_var()
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        redirectToLoginWithError("Formato email non valido.");
    }

    // Verifico che la password non sia vuota
    if (empty($password)) {
        redirectToLoginWithError("Il campo password è obbligatorio.");
    }

    // Verifico la lunghezza minima della password
    if (strlen($password) < 8) {
        redirectToLoginWithError("La password deve essere di almeno 8 caratteri.");
    }

    // -- STEP 3: Cerco l'utente nel database --

    include '../includes/db.php';

    // IMPORTANTE: uso prepare() + execute() invece di query() per prevenire SQL Injection!
    // Con query() un malintenzionato potrebbe inserire codice SQL nell'email.
    // Esempio di attacco: email = "' OR 1=1 --" → mostrerebbe tutti gli utenti!
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);

    // Recupero l'utente trovato (false se non esiste)
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifico se l'utente esiste
    if (!$user) {
        redirectToLoginWithError("Email o password non corretti.");
    }

    // -- STEP 4: Verifico la password --
    // password_verify() confronta la password in chiaro con l'hash salvato nel database
    // L'hash è stato generato con password_hash() durante la registrazione
    if (password_verify($password, $user['password'])) {
        // Autenticazione riuscita: salvo l'ID utente nella sessione
        $_SESSION['id'] = $user['id'];

        // Reindirizzo alla dashboard (pagina protetta)
        header('Location: ../index.php');
        exit;
    } else {
        // Password errata
        // NOTA: per sicurezza mostro un messaggio generico, senza specificare
        // se è l'email o la password ad essere sbagliata
        redirectToLoginWithError("Email o password non corretti.");
    }
}

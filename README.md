# Login System - PHP

Un sistema di **autenticazione** (login + registrazione) realizzato in PHP con gestione delle sessioni e database MySQL.

## Struttura del progetto

```
login-system/
├── index.php              # Dashboard protetta (accessibile solo dopo il login)
├── login.php              # Pagina con il form di login
├── registration.php       # Pagina con il form di registrazione
├── logout.php             # Logout e distruzione della sessione
├── api/
│   ├── login.php          # Logica di autenticazione (riceve i dati dal form)
│   └── registration.php   # Logica di registrazione (inserisce l'utente nel DB)
├── includes/
│   └── db.php             # Connessione al database MySQL con PDO
└── README.md
```

## Funzionalità

- **Registrazione** con username, email e password
- **Login** tramite email e password
- **Gestione delle sessioni PHP** (`session_start()`, `$_SESSION`)
- **Hashing sicuro della password** con `password_hash()` / `password_verify()` (bcrypt)
- **Validazione degli input** lato server:
  - Formato email corretto (`filter_var`)
  - Username non vuoto
  - Password di almeno 8 caratteri
- **Prepared statements** (PDO) per prevenire SQL Injection
- **Protezione delle pagine**: l'utente non autenticato viene reindirizzato al login
- **Messaggi di errore** mostrati tramite variabili di sessione (sopravvivono al redirect)
- **Logout sicuro** con distruzione completa della sessione
- **Prevenzione XSS**: `htmlspecialchars()` usato in output per escapare i dati utente

## Flusso dell'applicazione

### Registrazione

```
registration.php  →  (POST)  →  api/registration.php
                                        │
                              ┌─────────┴──────────┐
                              │                    │
                      Registrazione OK     Errore (es. email duplicata)
                              │                    │
                         login.php          registration.php
                                          (errore in sessione)
```

### Login

```
login.php  →  (POST)  →  api/login.php
                              │
                    ┌─────────┴─────────┐
                    │                   │
             Credenziali OK      Credenziali errate
                    │                   │
               index.php           login.php
             (Dashboard)        (errore in sessione)
```

### Logout

```
index.php  →  logout.php  →  login.php
               (distrugge la sessione)
```

## Concetti chiave per lo studio

| Concetto | Dove viene usato | Cosa fa |
|----------|-----------------|---------|
| `session_start()` | Tutti i file PHP | Avvia/riprende la sessione |
| `$_SESSION` | api/login.php, index.php | Memorizza dati tra una pagina e l'altra |
| `password_hash()` | api/registration.php | Genera un hash sicuro della password |
| `password_verify()` | api/login.php | Confronta password con hash salvato |
| `PDO::prepare()` | api/login.php, index.php | Previene SQL Injection |
| `htmlspecialchars()` | index.php, login.php | Previene attacchi XSS nell'output HTML |
| `filter_var()` | api/login.php, api/registration.php | Valida il formato dell'email |
| `header('Location:')` | Vari file | Reindirizza il browser a un'altra pagina |

## Database

### Configurazione

I parametri di connessione sono in `includes/db.php`:

| Parametro | Valore |
|-----------|--------|
| Host | `localhost` |
| Database | `php-corso-41` |
| Username | `root` |
| Password | *(vuota)* |

### Tabella `users`

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);
```

## Requisiti

- PHP 7.4 o superiore
- MySQL / MariaDB
- XAMPP (o qualsiasi server con supporto PHP, MySQL e sessioni)

## Avvio

1. Copia la cartella `login-system` in `htdocs` di XAMPP
2. Avvia **Apache** e **MySQL** dal pannello di controllo XAMPP
3. Crea il database `php-corso-41` e la tabella `users` (vedi sezione Database)
4. Visita `http://localhost/exercises/login-system/login.php` nel browser

## Sicurezza - Best Practice utilizzate

- Le password sono salvate come **hash bcrypt**, mai in chiaro
- Le query SQL usano **prepared statements** (previene SQL Injection)
- I dati in output sono escapati con **`htmlspecialchars()`** (previene XSS)
- `htmlspecialchars()` **NON** viene usato sull'input (romperebbe la verifica password)
- Le sessioni vengono distrutte completamente al logout (`session_unset()` + `session_destroy()`)

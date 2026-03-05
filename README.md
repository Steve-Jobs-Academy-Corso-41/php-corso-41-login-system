# Login System - PHP

Un sistema di autenticazione semplice realizzato in PHP con gestione delle sessioni.

## Struttura del progetto

```
login-system/
├── index.php        # Dashboard protetta (accessibile solo agli utenti autenticati)
├── login.php        # Pagina di login con il form HTML
├── logout.php       # Gestione del logout e distruzione della sessione
└── api/
    └── login.php    # Endpoint API che gestisce la logica di autenticazione
```

## Funzionalità

- **Autenticazione tramite email e password**
- **Gestione delle sessioni PHP** (`session_start`, `$_SESSION`)
- **Hashing della password** con `password_hash` / `password_verify` (bcrypt)
- **Validazione degli input**:
  - Formato email corretto
  - Password non vuota e di almeno 8 caratteri
- **Protezione delle pagine**: l'utente non autenticato viene reindirizzato al login
- **Messaggi di errore** visualizzati tramite variabili di sessione
- **Logout sicuro** con distruzione completa della sessione

## Flusso dell'applicazione

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

## Credenziali di test

| Campo    | Valore              |
|----------|---------------------|
| Email    | `user@example.com`  |
| Password | `password` (min 8 caratteri, hash bcrypt) |

> **Nota:** Le credenziali sono definite come costanti in `api/login.php` a scopo dimostrativo. In un'applicazione reale dovrebbero essere recuperate da un database.

## Requisiti

- PHP 7.4 o superiore
- XAMPP (o qualsiasi server con supporto PHP e sessioni)

## Avvio

1. Copia la cartella in `htdocs` di XAMPP.
2. Avvia Apache tramite il pannello di controllo XAMPP.
3. Visita `http://localhost/exercises/login-system/` nel browser.

## Sicurezza

- Le password sono conservate come hash bcrypt (non in chiaro).
- Gli input utente sono sanitizzati con `htmlspecialchars`.
- Le sessioni vengono distrutte completamente al logout (`session_unset` + `session_destroy`).

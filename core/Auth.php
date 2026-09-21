<?php
/**
 * Classe Auth
 * Gère l'authentification et la session des administrateurs.
 */
class Auth
{
    public static function demarrerSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_name(SESSION_NAME);
            session_start();
        }
    }

    public static function connecter(array $administrateur): void
    {
        self::demarrerSession();
        $_SESSION['admin_id']    = $administrateur['id'];
        $_SESSION['admin_nom']   = $administrateur['nom_complet'];
        $_SESSION['admin_role']  = $administrateur['role'];
    }

    public static function estConnecte(): bool
    {
        self::demarrerSession();
        return isset($_SESSION['admin_id']);
    }

    public static function exigerConnexion(): void
    {
        self::demarrerSession();
        if (!self::estConnecte()) {
            header('Location: login.php');
            exit;
        }
    }

    public static function deconnecter(): void
    {
        self::demarrerSession();
        $_SESSION = [];
        session_destroy();
    }

    public static function nomAdmin(): string
    {
        self::demarrerSession();
        return $_SESSION['admin_nom'] ?? '';
    }
}

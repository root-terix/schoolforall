<?php
/**
 * Classe Database
 * Fournit une connexion PDO unique (singleton) à la base de données MySQL.
 */
class Database
{
    private static ?PDO $connexion = null;

    public static function getConnexion(): PDO
    {
        if (self::$connexion === null) {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
            self::$connexion = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        }
        return self::$connexion;
    }
}

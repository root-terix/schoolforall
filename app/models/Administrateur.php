<?php
/**
 * Modèle Administrateur
 * Gère les comptes du tableau de bord.
 */
class Administrateur
{
    public static function trouverParEmail(string $email): ?array
    {
        $pdo = Database::getConnexion();
        $stmt = $pdo->prepare("SELECT * FROM administrateurs WHERE email = ?");
        $stmt->execute([$email]);
        $resultat = $stmt->fetch();
        return $resultat ?: null;
    }

    public static function verifierMotDePasse(string $motDePasseClair, string $motDePasseHache): bool
    {
        return password_verify($motDePasseClair, $motDePasseHache);
    }

    public static function creer(string $nomComplet, string $email, string $motDePasseClair, string $role = 'gestionnaire'): int
    {
        $pdo = Database::getConnexion();
        $motDePasseHache = password_hash($motDePasseClair, PASSWORD_ALGO);
        $stmt = $pdo->prepare(
            "INSERT INTO administrateurs (nom_complet, email, mot_de_passe, role) VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$nomComplet, $email, $motDePasseHache, $role]);
        return (int) $pdo->lastInsertId();
    }

    public static function tous(): array
    {
        $pdo = Database::getConnexion();
        return $pdo->query("SELECT id, nom_complet, email, role, cree_le FROM administrateurs ORDER BY nom_complet")->fetchAll();
    }
}

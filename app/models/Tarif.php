<?php
/**
 * Modèle Tarif
 * Grille tarifaire par niveau.
 */
class Tarif
{
    public static function creer(string $niveau, float $montant, string $periodicite, ?string $conditions): int
    {
        $pdo = Database::getConnexion();
        $stmt = $pdo->prepare(
            "INSERT INTO tarifs (niveau, montant, periodicite, conditions) VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$niveau, $montant, $periodicite, $conditions]);
        return (int) $pdo->lastInsertId();
    }

    public static function tous(): array
    {
        $pdo = Database::getConnexion();
        return $pdo->query("SELECT * FROM tarifs ORDER BY id")->fetchAll();
    }

    public static function supprimer(int $id): void
    {
        $pdo = Database::getConnexion();
        $stmt = $pdo->prepare("DELETE FROM tarifs WHERE id = ?");
        $stmt->execute([$id]);
    }
}

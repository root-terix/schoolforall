<?php
/**
 * Modèle Temoignage
 */
class Temoignage
{
    public static function creer(string $nomAuteur, ?string $statut, string $contenu, ?string $photo): int
    {
        $pdo = Database::getConnexion();
        $stmt = $pdo->prepare(
            "INSERT INTO temoignages (nom_auteur, statut, contenu, photo) VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$nomAuteur, $statut, $contenu, $photo]);
        return (int) $pdo->lastInsertId();
    }

    public static function tous(): array
    {
        $pdo = Database::getConnexion();
        return $pdo->query("SELECT * FROM temoignages ORDER BY cree_le DESC")->fetchAll();
    }

    public static function supprimer(int $id): void
    {
        $pdo = Database::getConnexion();
        $stmt = $pdo->prepare("DELETE FROM temoignages WHERE id = ?");
        $stmt->execute([$id]);
    }
}

<?php
/**
 * Modèle Planning
 * Horaires des cours par niveau.
 */
class Planning
{
    public static function creer(string $niveau, string $jourSemaine, string $heureDebut, string $heureFin, ?string $lieu): int
    {
        $pdo = Database::getConnexion();
        $stmt = $pdo->prepare(
            "INSERT INTO planning (niveau, jour_semaine, heure_debut, heure_fin, lieu) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([$niveau, $jourSemaine, $heureDebut, $heureFin, $lieu]);
        return (int) $pdo->lastInsertId();
    }

    public static function tous(): array
    {
        $pdo = Database::getConnexion();
        return $pdo->query("SELECT * FROM planning ORDER BY FIELD(jour_semaine,'Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'), heure_debut")->fetchAll();
    }

    public static function supprimer(int $id): void
    {
        $pdo = Database::getConnexion();
        $stmt = $pdo->prepare("DELETE FROM planning WHERE id = ?");
        $stmt->execute([$id]);
    }
}

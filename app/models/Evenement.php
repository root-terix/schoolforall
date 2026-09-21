<?php
/**
 * Modèle Evenement
 * Gère les événements (olympiades, cérémonies, concours, etc.) et leur galerie.
 */
class Evenement
{
    public static function creer(string $titre, ?string $description, string $dateEvenement, ?string $lieu, ?string $imageCouverture): int
    {
        $pdo = Database::getConnexion();
        $stmt = $pdo->prepare(
            "INSERT INTO evenements (titre, description, date_evenement, lieu, image_couverture)
             VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([$titre, $description, $dateEvenement, $lieu, $imageCouverture]);
        return (int) $pdo->lastInsertId();
    }

    public static function aVenir(): array
    {
        $pdo = Database::getConnexion();
        return $pdo->query("SELECT * FROM evenements WHERE date_evenement >= CURDATE() ORDER BY date_evenement ASC")->fetchAll();
    }

    public static function passes(): array
    {
        $pdo = Database::getConnexion();
        return $pdo->query("SELECT * FROM evenements WHERE date_evenement < CURDATE() ORDER BY date_evenement DESC")->fetchAll();
    }

    public static function tous(): array
    {
        $pdo = Database::getConnexion();
        return $pdo->query("SELECT * FROM evenements ORDER BY date_evenement DESC")->fetchAll();
    }

    public static function trouver(int $id): ?array
    {
        $pdo = Database::getConnexion();
        $stmt = $pdo->prepare("SELECT * FROM evenements WHERE id = ?");
        $stmt->execute([$id]);
        $resultat = $stmt->fetch();
        return $resultat ?: null;
    }

    public static function ajouterImageGalerie(int $evenementId, string $cheminImage): void
    {
        $pdo = Database::getConnexion();
        $stmt = $pdo->prepare("INSERT INTO evenement_images (evenement_id, chemin_image) VALUES (?, ?)");
        $stmt->execute([$evenementId, $cheminImage]);
    }

    public static function galerie(int $evenementId): array
    {
        $pdo = Database::getConnexion();
        $stmt = $pdo->prepare("SELECT * FROM evenement_images WHERE evenement_id = ?");
        $stmt->execute([$evenementId]);
        return $stmt->fetchAll();
    }

    public static function supprimer(int $id): void
    {
        $pdo = Database::getConnexion();
        $stmt = $pdo->prepare("DELETE FROM evenements WHERE id = ?");
        $stmt->execute([$id]);
    }
}

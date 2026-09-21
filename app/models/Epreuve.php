<?php
/**
 * Modèle Epreuve
 * Gère les sujets d'examens et leurs corrigés.
 */
class Epreuve
{
    public static function creer(string $typeExamen, string $matiere, int $annee, ?string $fichierSujet, ?string $fichierCorrige): int
    {
        $pdo = Database::getConnexion();
        $stmt = $pdo->prepare(
            "INSERT INTO epreuves (type_examen, matiere, annee, fichier_sujet, fichier_corrige)
             VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([$typeExamen, $matiere, $annee, $fichierSujet, $fichierCorrige]);
        return (int) $pdo->lastInsertId();
    }

    public static function tous(?string $typeExamen = null): array
    {
        $pdo = Database::getConnexion();
        if ($typeExamen) {
            $stmt = $pdo->prepare("SELECT * FROM epreuves WHERE type_examen = ? ORDER BY annee DESC");
            $stmt->execute([$typeExamen]);
            return $stmt->fetchAll();
        }
        return $pdo->query("SELECT * FROM epreuves ORDER BY type_examen, annee DESC")->fetchAll();
    }

    public static function supprimer(int $id): void
    {
        $pdo = Database::getConnexion();
        $stmt = $pdo->prepare("DELETE FROM epreuves WHERE id = ?");
        $stmt->execute([$id]);
    }
}

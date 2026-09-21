<?php
/**
 * Modèle Resultat
 * Taux de réussite aux examens officiels (Bac, Probatoire, BEPC, ETNS).
 */
class Resultat
{
    public static function enregistrer(string $typeExamen, int $annee, float $tauxReussite): void
    {
        $pdo = Database::getConnexion();
        $stmt = $pdo->prepare(
            "INSERT INTO resultats (type_examen, annee, taux_reussite) VALUES (?, ?, ?)
             ON DUPLICATE KEY UPDATE taux_reussite = VALUES(taux_reussite)"
        );
        $stmt->execute([$typeExamen, $annee, $tauxReussite]);
    }

    public static function tous(): array
    {
        $pdo = Database::getConnexion();
        return $pdo->query("SELECT * FROM resultats ORDER BY annee DESC, type_examen")->fetchAll();
    }

    public static function dernierAnnee(): array
    {
        $pdo = Database::getConnexion();
        $anneeMax = $pdo->query("SELECT MAX(annee) FROM resultats")->fetchColumn();
        if (!$anneeMax) {
            return [];
        }
        $stmt = $pdo->prepare("SELECT * FROM resultats WHERE annee = ?");
        $stmt->execute([$anneeMax]);
        return $stmt->fetchAll();
    }

    public static function supprimer(int $id): void
    {
        $pdo = Database::getConnexion();
        $stmt = $pdo->prepare("DELETE FROM resultats WHERE id = ?");
        $stmt->execute([$id]);
    }
}

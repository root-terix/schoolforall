<?php
/**
 * Modèle Enseignant
 */
class Enseignant
{
    public static function creer(string $nomComplet, ?string $photo, string $matiere, ?string $qualifications, ?string $parcours, ?string $poste = null, ?int $responsableId = null): int
    {
        $pdo = Database::getConnexion();
        $stmt = $pdo->prepare(
            "INSERT INTO enseignants (nom_complet, photo, matiere, poste, responsable_id, qualifications, parcours)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([$nomComplet, $photo, $matiere, $poste, $responsableId ?: null, $qualifications, $parcours]);
        return (int) $pdo->lastInsertId();
    }

    public static function tous(): array
    {
        $pdo = Database::getConnexion();
        return $pdo->query("SELECT * FROM enseignants ORDER BY (responsable_id IS NULL) DESC, nom_complet")->fetchAll();
    }

    public static function trouver(int $id): ?array
    {
        $pdo = Database::getConnexion();
        $stmt = $pdo->prepare("SELECT * FROM enseignants WHERE id = ?");
        $stmt->execute([$id]);
        $resultat = $stmt->fetch();
        return $resultat ?: null;
    }

    /**
     * Retourne l'équipe organisée en arbre hiérarchique (écosystème) :
     * chaque nœud racine (responsable_id NULL) contient ses "enfants" dans la clé "equipe".
     */
    public static function arbreHierarchique(): array
    {
        $tous = self::tous();
        $parId = [];
        foreach ($tous as $personne) {
            $personne['equipe'] = [];
            $parId[$personne['id']] = $personne;
        }
        $racines = [];
        foreach ($parId as $id => $personne) {
            if ($personne['responsable_id'] && isset($parId[$personne['responsable_id']])) {
                $parId[$personne['responsable_id']]['equipe'][] = &$parId[$id];
            } else {
                $racines[] = &$parId[$id];
            }
        }
        return $racines;
    }

    public static function supprimer(int $id): void
    {
        $pdo = Database::getConnexion();
        $stmt = $pdo->prepare("DELETE FROM enseignants WHERE id = ?");
        $stmt->execute([$id]);
    }
}

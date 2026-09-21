<?php
/**
 * Modèle Eleve
 * Représente un élève inscrit (via le formulaire public ou l'import admin).
 */
class Eleve
{
    public static function creer(array $donnees): int
    {
        $pdo = Database::getConnexion();
        $sql = "INSERT INTO eleves
            (photo, nom, prenom, date_naissance, lieu_naissance, nationalite, numero_telephone,
             etablissement, classe, serie, annee_scolaire, statut, adresse, date_debut_cours,
             contact_urgence_nom, contact_urgence_numero, contact_urgence_adresse, moyen_decouverte,
             a_difficulte_scolaire, details_difficulte, projet_carriere, reglement_accepte, source_import)
            VALUES
            (:photo, :nom, :prenom, :date_naissance, :lieu_naissance, :nationalite, :numero_telephone,
             :etablissement, :classe, :serie, :annee_scolaire, :statut, :adresse, :date_debut_cours,
             :contact_urgence_nom, :contact_urgence_numero, :contact_urgence_adresse, :moyen_decouverte,
             :a_difficulte_scolaire, :details_difficulte, :projet_carriere, :reglement_accepte, :source_import)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':photo'                   => $donnees['photo'] ?? null,
            ':nom'                     => $donnees['nom'],
            ':prenom'                  => $donnees['prenom'],
            ':date_naissance'          => $donnees['date_naissance'] ?? null,
            ':lieu_naissance'          => $donnees['lieu_naissance'] ?? null,
            ':nationalite'             => $donnees['nationalite'] ?? null,
            ':numero_telephone'        => $donnees['numero_telephone'] ?? null,
            ':etablissement'           => $donnees['etablissement'] ?? null,
            ':classe'                  => $donnees['classe'],
            ':serie'                   => $donnees['serie'] ?? null,
            ':annee_scolaire'          => $donnees['annee_scolaire'] ?? null,
            ':statut'                  => $donnees['statut'] ?? 'nouveau',
            ':adresse'                 => $donnees['adresse'] ?? null,
            ':date_debut_cours'        => $donnees['date_debut_cours'] ?? null,
            ':contact_urgence_nom'     => $donnees['contact_urgence_nom'] ?? null,
            ':contact_urgence_numero'  => $donnees['contact_urgence_numero'] ?? null,
            ':contact_urgence_adresse' => $donnees['contact_urgence_adresse'] ?? null,
            ':moyen_decouverte'        => $donnees['moyen_decouverte'] ?? null,
            ':a_difficulte_scolaire'   => !empty($donnees['a_difficulte_scolaire']) ? 1 : 0,
            ':details_difficulte'      => $donnees['details_difficulte'] ?? null,
            ':projet_carriere'         => $donnees['projet_carriere'] ?? null,
            ':reglement_accepte'       => !empty($donnees['reglement_accepte']) ? 1 : 0,
            ':source_import'           => $donnees['source_import'] ?? 'formulaire',
        ]);
        return (int) $pdo->lastInsertId();
    }

    public static function creerDepuisImport(array $donnees): int
    {
        $donnees['source_import'] = 'import_admin';
        $donnees['reglement_accepte'] = $donnees['reglement_accepte'] ?? 1;
        return self::creer($donnees);
    }

    public static function tous(): array
    {
        $pdo = Database::getConnexion();
        return $pdo->query("SELECT * FROM eleves ORDER BY cree_le DESC")->fetchAll();
    }

    public static function trouver(int $id): ?array
    {
        $pdo = Database::getConnexion();
        $stmt = $pdo->prepare("SELECT * FROM eleves WHERE id = ?");
        $stmt->execute([$id]);
        $resultat = $stmt->fetch();
        return $resultat ?: null;
    }

    public static function supprimer(int $id): void
    {
        $pdo = Database::getConnexion();
        $stmt = $pdo->prepare("DELETE FROM eleves WHERE id = ?");
        $stmt->execute([$id]);
    }

    public static function compter(): int
    {
        $pdo = Database::getConnexion();
        return (int) $pdo->query("SELECT COUNT(*) FROM eleves")->fetchColumn();
    }

    /**
     * Nombre d'inscriptions par mois sur les 7 derniers mois (pour graphique en courbe).
     */
    public static function parMois(): array
    {
        $pdo = Database::getConnexion();
        $sql = "SELECT DATE_FORMAT(cree_le, '%Y-%m') AS mois, COUNT(*) AS total
                FROM eleves
                WHERE cree_le >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                GROUP BY mois ORDER BY mois";
        return $pdo->query($sql)->fetchAll();
    }

    /**
     * Répartition des élèves par niveau (pour graphique en anneau).
     */
    public static function parNiveau(): array
    {
        $pdo = Database::getConnexion();
        return $pdo->query("SELECT classe, COUNT(*) AS total FROM eleves GROUP BY classe ORDER BY total DESC")->fetchAll();
    }

    /**
     * Répartition nouveaux vs anciens élèves (pour graphique en anneau).
     */
    public static function parStatut(): array
    {
        $pdo = Database::getConnexion();
        return $pdo->query("SELECT statut, COUNT(*) AS total FROM eleves GROUP BY statut")->fetchAll();
    }

    /**
     * Répartition des inscriptions par jour de la semaine (pour graphique en barres).
     */
    public static function parJourSemaine(): array
    {
        $pdo = Database::getConnexion();
        $sql = "SELECT DAYOFWEEK(cree_le) AS jour, COUNT(*) AS total FROM eleves GROUP BY jour";
        $lignes = $pdo->query($sql)->fetchAll();
        $parIndex = array_fill(1, 7, 0);
        foreach ($lignes as $l) { $parIndex[(int)$l['jour']] = (int)$l['total']; }
        return $parIndex; // index 1 = dimanche ... 7 = samedi (convention MySQL)
    }
}

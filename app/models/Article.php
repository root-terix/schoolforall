<?php
/**
 * Modèle Article
 * Gère les publications de la newsletter/blog (type post Facebook).
 */
class Article
{
    public static function creer(string $titre, string $contenu, ?string $image, int $administrateurId): int
    {
        $pdo = Database::getConnexion();
        $stmt = $pdo->prepare(
            "INSERT INTO articles_blog (titre, contenu, image, administrateur_id, est_publie)
             VALUES (?, ?, ?, ?, 1)"
        );
        $stmt->execute([$titre, $contenu, $image, $administrateurId]);
        return (int) $pdo->lastInsertId();
    }

    public static function tous(bool $publiesUniquement = true): array
    {
        $pdo = Database::getConnexion();
        $sql = "SELECT a.*,
                    (SELECT COUNT(*) FROM likes l WHERE l.article_id = a.id) AS nombre_likes,
                    (SELECT COUNT(*) FROM commentaires c WHERE c.article_id = a.id AND c.est_valide = 1) AS nombre_commentaires
                FROM articles_blog a";
        if ($publiesUniquement) {
            $sql .= " WHERE a.est_publie = 1";
        }
        $sql .= " ORDER BY a.cree_le DESC";
        return $pdo->query($sql)->fetchAll();
    }

    public static function trouver(int $id): ?array
    {
        $pdo = Database::getConnexion();
        $stmt = $pdo->prepare("SELECT * FROM articles_blog WHERE id = ?");
        $stmt->execute([$id]);
        $resultat = $stmt->fetch();
        return $resultat ?: null;
    }

    public static function supprimer(int $id): void
    {
        $pdo = Database::getConnexion();
        $stmt = $pdo->prepare("DELETE FROM articles_blog WHERE id = ?");
        $stmt->execute([$id]);
    }

    public static function basculerPublication(int $id): void
    {
        $pdo = Database::getConnexion();
        $stmt = $pdo->prepare("UPDATE articles_blog SET est_publie = NOT est_publie WHERE id = ?");
        $stmt->execute([$id]);
    }

    // ---------------- Likes ----------------
    public static function ajouterLike(int $articleId, string $identifiantVisiteur): void
    {
        $pdo = Database::getConnexion();
        $stmt = $pdo->prepare(
            "INSERT IGNORE INTO likes (article_id, identifiant_visiteur) VALUES (?, ?)"
        );
        $stmt->execute([$articleId, $identifiantVisiteur]);
    }

    public static function retirerLike(int $articleId, string $identifiantVisiteur): void
    {
        $pdo = Database::getConnexion();
        $stmt = $pdo->prepare(
            "DELETE FROM likes WHERE article_id = ? AND identifiant_visiteur = ?"
        );
        $stmt->execute([$articleId, $identifiantVisiteur]);
    }

    public static function aAimeParVisiteur(int $articleId, string $identifiantVisiteur): bool
    {
        $pdo = Database::getConnexion();
        $stmt = $pdo->prepare(
            "SELECT COUNT(*) FROM likes WHERE article_id = ? AND identifiant_visiteur = ?"
        );
        $stmt->execute([$articleId, $identifiantVisiteur]);
        return (bool) $stmt->fetchColumn();
    }

    public static function compterLikes(int $articleId): int
    {
        $pdo = Database::getConnexion();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM likes WHERE article_id = ?");
        $stmt->execute([$articleId]);
        return (int) $stmt->fetchColumn();
    }

    // ---------------- Commentaires ----------------
    public static function ajouterCommentaire(int $articleId, string $nomAuteur, string $contenu): int
    {
        $pdo = Database::getConnexion();
        $stmt = $pdo->prepare(
            "INSERT INTO commentaires (article_id, nom_auteur, contenu, est_valide) VALUES (?, ?, ?, 1)"
        );
        $stmt->execute([$articleId, $nomAuteur, $contenu]);
        return (int) $pdo->lastInsertId();
    }

    public static function commentaires(int $articleId): array
    {
        $pdo = Database::getConnexion();
        $stmt = $pdo->prepare(
            "SELECT * FROM commentaires WHERE article_id = ? AND est_valide = 1 ORDER BY cree_le ASC"
        );
        $stmt->execute([$articleId]);
        return $stmt->fetchAll();
    }
}

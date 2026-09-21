<?php
/**
 * Basculer le like d'un visiteur sur un article (AJAX).
 */
require_once __DIR__ . '/../config/bootstrap.php';
header('Content-Type: application/json; charset=utf-8');
Auth::demarrerSession();

if (!isset($_SESSION['visiteur_id'])) {
    $_SESSION['visiteur_id'] = bin2hex(random_bytes(8));
}
$visiteurId = $_SESSION['visiteur_id'];
$articleId = (int)($_POST['article_id'] ?? 0);

if (!$articleId) {
    echo json_encode(['succes' => false]);
    exit;
}

if (Article::aAimeParVisiteur($articleId, $visiteurId)) {
    Article::retirerLike($articleId, $visiteurId);
    $actif = false;
} else {
    Article::ajouterLike($articleId, $visiteurId);
    $actif = true;
}

echo json_encode([
    'succes' => true,
    'actif'  => $actif,
    'total'  => Article::compterLikes($articleId),
]);

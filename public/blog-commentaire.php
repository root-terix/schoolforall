<?php
/**
 * Ajouter un commentaire à un article (AJAX).
 */
require_once __DIR__ . '/../config/bootstrap.php';
header('Content-Type: application/json; charset=utf-8');

$articleId = (int)($_POST['article_id'] ?? 0);
$nomAuteur = trim($_POST['nom_auteur'] ?? '');
$contenu   = trim($_POST['contenu'] ?? '');

if (!$articleId || $nomAuteur === '' || $contenu === '') {
    echo json_encode(['succes' => false, 'message' => 'Merci de remplir votre nom et votre commentaire.']);
    exit;
}

$id = Article::ajouterCommentaire($articleId, $nomAuteur, $contenu);

echo json_encode([
    'succes'     => true,
    'nomAuteur'  => htmlspecialchars($nomAuteur),
    'contenu'    => htmlspecialchars($contenu),
    'date'       => date('d/m/Y H:i'),
]);

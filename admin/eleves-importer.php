<?php
/**
 * Reçoit la liste des élèves lue côté client (SheetJS) au format JSON
 * et les enregistre en base de données.
 */
require_once __DIR__ . '/../config/bootstrap.php';
Auth::exigerConnexion();
header('Content-Type: application/json; charset=utf-8');

$donneesRecues = json_decode(file_get_contents('php://input'), true);
$listeEleves = $donneesRecues['eleves'] ?? [];

if (!is_array($listeEleves) || empty($listeEleves)) {
    echo json_encode(['succes' => false, 'message' => 'Aucune donnée reçue.']);
    exit;
}

$nombreImportes = 0;
foreach ($listeEleves as $ligne) {
    // Normalisation des clés (insensible à la casse, espaces)
    $ligneNormalisee = [];
    foreach ($ligne as $cle => $valeur) {
        $ligneNormalisee[strtolower(trim($cle))] = trim((string)$valeur);
    }

    if (empty($ligneNormalisee['nom']) || empty($ligneNormalisee['prenom']) || empty($ligneNormalisee['classe'])) {
        continue; // ligne incomplète, ignorée
    }

    Eleve::creerDepuisImport([
        'nom'               => $ligneNormalisee['nom'],
        'prenom'            => $ligneNormalisee['prenom'],
        'classe'            => $ligneNormalisee['classe'],
        'serie'             => $ligneNormalisee['serie'] ?? null,
        'numero_telephone'  => $ligneNormalisee['numero_telephone'] ?? null,
        'statut'            => in_array($ligneNormalisee['statut'] ?? '', ['nouveau','ancien']) ? $ligneNormalisee['statut'] : 'ancien',
    ]);
    $nombreImportes++;
}

echo json_encode(['succes' => true, 'nombreImportes' => $nombreImportes]);

<?php
/**
 * Traitement du formulaire d'inscription en ligne.
 * Valide les données, les enregistre en base, puis renvoie un lien
 * WhatsApp (click-to-chat) pré-rempli avec le récapitulatif de la fiche.
 */
require_once __DIR__ . '/../config/bootstrap.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['succes' => false, 'message' => 'Méthode non autorisée.']);
    exit;
}

// ---------- Validation côté serveur ----------
$erreurs = [];
$nom    = trim($_POST['nom'] ?? '');
$prenom = trim($_POST['prenom'] ?? '');
$numero = trim($_POST['numero_telephone'] ?? '');
$classe = trim($_POST['classe'] ?? '');

if ($nom === '')    { $erreurs[] = 'Le nom est obligatoire.'; }
if ($prenom === '') { $erreurs[] = 'Le prénom est obligatoire.'; }
if ($numero === '') { $erreurs[] = 'Le numéro de téléphone est obligatoire.'; }
if ($classe === '') { $erreurs[] = 'La classe est obligatoire.'; }
if (empty($_POST['reglement_accepte'])) { $erreurs[] = 'Vous devez accepter le règlement intérieur.'; }

if ($erreurs) {
    echo json_encode(['succes' => false, 'message' => implode(' ', $erreurs)]);
    exit;
}

// ---------- Upload de la photo (facultatif) ----------
$nomPhoto = null;
if (!empty($_FILES['photo']['name'])) {
    $extension = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
    if (in_array($extension, ALLOWED_IMAGE_EXTENSIONS) && $_FILES['photo']['size'] <= UPLOAD_MAX_SIZE) {
        $nomPhoto = 'eleve_' . time() . '_' . bin2hex(random_bytes(3)) . '.' . $extension;
        move_uploaded_file($_FILES['photo']['tmp_name'], UPLOAD_PATH . 'photos/' . $nomPhoto);
    }
}

// ---------- Enregistrement en base ----------
$donnees = [
    'photo'                   => $nomPhoto,
    'nom'                     => $nom,
    'prenom'                  => $prenom,
    'date_naissance'          => $_POST['date_naissance'] ?: null,
    'lieu_naissance'          => trim($_POST['lieu_naissance'] ?? ''),
    'nationalite'             => trim($_POST['nationalite'] ?? ''),
    'numero_telephone'        => $numero,
    'etablissement'           => trim($_POST['etablissement'] ?? ''),
    'classe'                  => $classe,
    'serie'                   => trim($_POST['serie'] ?? ''),
    'annee_scolaire'          => trim($_POST['annee_scolaire'] ?? ''),
    'statut'                  => in_array($_POST['statut'] ?? '', ['nouveau','ancien']) ? $_POST['statut'] : 'nouveau',
    'adresse'                 => trim($_POST['adresse'] ?? ''),
    'date_debut_cours'        => $_POST['date_debut_cours'] ?: null,
    'contact_urgence_nom'     => trim($_POST['contact_urgence_nom'] ?? ''),
    'contact_urgence_numero'  => trim($_POST['contact_urgence_numero'] ?? ''),
    'contact_urgence_adresse' => trim($_POST['contact_urgence_adresse'] ?? ''),
    'moyen_decouverte'        => trim($_POST['moyen_decouverte'] ?? ''),
    'a_difficulte_scolaire'   => (int)($_POST['a_difficulte_scolaire'] ?? 0),
    'details_difficulte'      => trim($_POST['details_difficulte'] ?? ''),
    'projet_carriere'         => trim($_POST['projet_carriere'] ?? ''),
    'reglement_accepte'       => 1,
    'source_import'           => 'formulaire',
];

try {
    $id = Eleve::creer($donnees);
} catch (Exception $e) {
    echo json_encode(['succes' => false, 'message' => "Une erreur est survenue lors de l'enregistrement."]);
    exit;
}

// ---------- Construction du récapitulatif WhatsApp ----------
$recapitulatif = "*Nouvelle inscription — SCHOOL FOR ALL*\n"
    . "Nom : {$nom}\n"
    . "Prénom : {$prenom}\n"
    . "Classe : {$classe}" . ($donnees['serie'] ? " ({$donnees['serie']})" : "") . "\n"
    . "Statut : {$donnees['statut']}\n"
    . "Téléphone : {$numero}\n"
    . "Établissement : {$donnees['etablissement']}\n"
    . "Réf. dossier : #{$id}\n\n"
    . "(La fiche d'inscription complète en PDF est jointe / téléchargée séparément.)";

// ---------- Renvoi des données complètes pour générer la fiche imprimable / PDF ----------
echo json_encode([
    'succes'          => true,
    'message'         => "Votre fiche a bien été enregistrée (réf. #{$id}). Vous pouvez maintenant l'imprimer, la télécharger en PDF ou l'envoyer sur WhatsApp.",
    'numeroWhatsapp'  => WHATSAPP_NUMBER,
    'recapitulatif'   => $recapitulatif,
    'fiche'           => [
        'reference'               => $id,
        'photo'                   => $nomPhoto ? UPLOAD_URL . 'photos/' . $nomPhoto : null,
        'nom'                     => $nom,
        'prenom'                  => $prenom,
        'date_naissance'          => $donnees['date_naissance'],
        'lieu_naissance'          => $donnees['lieu_naissance'],
        'nationalite'             => $donnees['nationalite'],
        'numero_telephone'        => $numero,
        'etablissement'           => $donnees['etablissement'],
        'classe'                  => $classe,
        'serie'                   => $donnees['serie'],
        'annee_scolaire'          => $donnees['annee_scolaire'],
        'statut'                  => $donnees['statut'],
        'adresse'                 => $donnees['adresse'],
        'date_debut_cours'        => $donnees['date_debut_cours'],
        'contact_urgence_nom'     => $donnees['contact_urgence_nom'],
        'contact_urgence_numero'  => $donnees['contact_urgence_numero'],
        'contact_urgence_adresse' => $donnees['contact_urgence_adresse'],
        'moyen_decouverte'        => $donnees['moyen_decouverte'],
        'a_difficulte_scolaire'   => (bool)$donnees['a_difficulte_scolaire'],
        'details_difficulte'      => $donnees['details_difficulte'],
        'projet_carriere'         => $donnees['projet_carriere'],
        'date_inscription'        => date('d/m/Y à H:i'),
    ],
]);

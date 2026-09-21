<?php
require_once __DIR__ . '/../config/bootstrap.php';
Auth::exigerConnexion();

$pageActive = 'enseignants';
$titrePage = 'Équipe pédagogique — Écosystème';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'creer') {
    $nomComplet = trim($_POST['nom_complet'] ?? '');
    $matiere = trim($_POST['matiere'] ?? '');
    $poste = trim($_POST['poste'] ?? '');
    $responsableId = (int)($_POST['responsable_id'] ?? 0);
    $qualifications = trim($_POST['qualifications'] ?? '');
    $parcours = trim($_POST['parcours'] ?? '');
    $nomPhoto = null;

    if (!empty($_FILES['photo']['name'])) {
        $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ALLOWED_IMAGE_EXTENSIONS)) {
            $nomPhoto = 'enseignant_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['photo']['tmp_name'], UPLOAD_PATH . 'photos/' . $nomPhoto);
        }
    }

    if ($nomComplet && $matiere) {
        Enseignant::creer($nomComplet, $nomPhoto, $matiere, $qualifications, $parcours, $poste ?: null, $responsableId ?: null);
        $message = 'Membre ajouté à l\'écosystème avec succès.';
    }
}

if (isset($_GET['supprimer'])) {
    Enseignant::supprimer((int)$_GET['supprimer']);
    header('Location: enseignants.php'); exit;
}

$enseignants = Enseignant::tous();
require __DIR__ . '/includes/admin-header.php';
?>

<?php if ($message): ?><div class="alert alert-success"><?= htmlspecialchars($message) ?></div><?php endif; ?>

<div class="sfa-admin-card p-4 mb-4" data-aos="fade-up">
  <h6 class="fw-bold mb-1">Ajouter un membre à l'écosystème</h6>
  <p class="text-secondary small mb-3">
    Laissez « Responsable hiérarchique » vide pour créer un <strong>dirigeant</strong> (nœud central de l'organigramme public).
    Sinon, sélectionnez à qui ce membre est rattaché pour qu'il apparaisse connecté à lui sur la page « Équipe ».
  </p>
  <form method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="creer">
    <div class="row g-3">
      <div class="col-md-4">
        <label class="form-label">Nom complet</label>
        <input type="text" class="form-control" name="nom_complet" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">Matière / Domaine</label>
        <input type="text" class="form-control" name="matiere" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">Photo</label>
        <input type="file" class="form-control" name="photo" accept="image/*">
      </div>
      <div class="col-md-4">
        <label class="form-label">Poste (ex : Directeur, Coordonnateur, Enseignant)</label>
        <input type="text" class="form-control" name="poste">
      </div>
      <div class="col-md-4">
        <label class="form-label">Responsable hiérarchique</label>
        <select class="form-select" name="responsable_id">
          <option value="">— Aucun (dirigeant / nœud central) —</option>
          <?php foreach ($enseignants as $ens): ?>
            <option value="<?= $ens['id'] ?>"><?= htmlspecialchars($ens['nom_complet']) ?> (<?= htmlspecialchars($ens['poste'] ?? $ens['matiere']) ?>)</option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Qualifications</label>
        <input type="text" class="form-control" name="qualifications">
      </div>
      <div class="col-12">
        <label class="form-label">Parcours</label>
        <textarea class="form-control" name="parcours" rows="2"></textarea>
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-sfa-primary">Ajouter à l'écosystème</button>
      </div>
    </div>
  </form>
</div>

<div class="sfa-admin-card p-4" data-aos="fade-up">
  <h6 class="fw-bold mb-3">Organigramme actuel</h6>
  <div class="table-responsive">
    <table class="table align-middle">
      <thead><tr><th>Nom</th><th>Poste</th><th>Matière</th><th>Rattaché à</th><th>Actions</th></tr></thead>
      <tbody>
        <?php
        $parId = [];
        foreach ($enseignants as $e) { $parId[$e['id']] = $e['nom_complet']; }
        foreach ($enseignants as $ens): ?>
          <tr>
            <td><?= htmlspecialchars($ens['nom_complet']) ?></td>
            <td><span class="badge" style="background:var(--sfa-pink-light); color:var(--sfa-pink-dark)"><?= htmlspecialchars($ens['poste'] ?? '—') ?></span></td>
            <td><?= htmlspecialchars($ens['matiere']) ?></td>
            <td><?= $ens['responsable_id'] ? htmlspecialchars($parId[$ens['responsable_id']] ?? '—') : '<em class="text-secondary">Nœud central</em>' ?></td>
            <td><a href="enseignants.php?supprimer=<?= $ens['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer ce membre ?')"><i class="bi bi-trash"></i></a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require __DIR__ . '/includes/admin-footer.php'; ?>

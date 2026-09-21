<?php
require_once __DIR__ . '/../config/bootstrap.php';
Auth::exigerConnexion();

$pageActive = 'epreuves';
$titrePage = 'Épreuves & corrigés';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'creer') {
    $typeExamen = $_POST['type_examen'] ?? '';
    $matiere = trim($_POST['matiere'] ?? '');
    $annee = (int)($_POST['annee'] ?? 0);
    $fichierSujet = null;
    $fichierCorrige = null;

    if (!empty($_FILES['fichier_sujet']['name'])) {
        $ext = strtolower(pathinfo($_FILES['fichier_sujet']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ALLOWED_DOCUMENT_EXTENSIONS)) {
            $fichierSujet = 'sujet_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['fichier_sujet']['tmp_name'], UPLOAD_PATH . 'epreuves/' . $fichierSujet);
        }
    }
    if (!empty($_FILES['fichier_corrige']['name'])) {
        $ext = strtolower(pathinfo($_FILES['fichier_corrige']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ALLOWED_DOCUMENT_EXTENSIONS)) {
            $fichierCorrige = 'corrige_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['fichier_corrige']['tmp_name'], UPLOAD_PATH . 'epreuves/' . $fichierCorrige);
        }
    }

    if ($typeExamen && $matiere && $annee) {
        Epreuve::creer($typeExamen, $matiere, $annee, $fichierSujet, $fichierCorrige);
        $message = 'Épreuve ajoutée avec succès.';
    }
}

if (isset($_GET['supprimer'])) {
    Epreuve::supprimer((int)$_GET['supprimer']);
    header('Location: epreuves.php'); exit;
}

$epreuves = Epreuve::tous();
require __DIR__ . '/includes/admin-header.php';
?>

<?php if ($message): ?><div class="alert alert-success"><?= htmlspecialchars($message) ?></div><?php endif; ?>

<div class="card border-0 shadow-sm p-4 mb-4">
  <h6 class="fw-bold mb-3">Ajouter une épreuve</h6>
  <form method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="creer">
    <div class="row g-3">
      <div class="col-md-3">
        <label class="form-label">Examen</label>
        <select class="form-select" name="type_examen" required>
          <option value="BEPC">BEPC</option>
          <option value="Probatoire">Probatoire</option>
          <option value="Baccalaureat">Baccalauréat</option>
          <option value="ETNS">ETNS</option>
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label">Matière</label>
        <input type="text" class="form-control" name="matiere" required>
      </div>
      <div class="col-md-2">
        <label class="form-label">Année</label>
        <input type="number" class="form-control" name="annee" min="2000" max="2100" required>
      </div>
      <div class="col-md-2">
        <label class="form-label">Sujet (PDF)</label>
        <input type="file" class="form-control" name="fichier_sujet" accept=".pdf,.doc,.docx">
      </div>
      <div class="col-md-2">
        <label class="form-label">Corrigé (PDF)</label>
        <input type="file" class="form-control" name="fichier_corrige" accept=".pdf,.doc,.docx">
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-sfa-primary"><i class="bi bi-upload"></i> Ajouter</button>
      </div>
    </div>
  </form>
</div>

<div class="card border-0 shadow-sm p-4">
  <h6 class="fw-bold mb-3">Épreuves en ligne</h6>
  <div class="table-responsive">
    <table class="table align-middle">
      <thead><tr><th>Examen</th><th>Matière</th><th>Année</th><th>Sujet</th><th>Corrigé</th><th>Actions</th></tr></thead>
      <tbody>
        <?php foreach ($epreuves as $ep): ?>
          <tr>
            <td><?= htmlspecialchars($ep['type_examen']) ?></td>
            <td><?= htmlspecialchars($ep['matiere']) ?></td>
            <td><?= $ep['annee'] ?></td>
            <td><?= $ep['fichier_sujet'] ? '<span class="badge bg-success">Oui</span>' : '<span class="badge bg-secondary">Non</span>' ?></td>
            <td><?= $ep['fichier_corrige'] ? '<span class="badge bg-success">Oui</span>' : '<span class="badge bg-secondary">Non</span>' ?></td>
            <td><a href="epreuves.php?supprimer=<?= $ep['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer ?')"><i class="bi bi-trash"></i></a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require __DIR__ . '/includes/admin-footer.php'; ?>

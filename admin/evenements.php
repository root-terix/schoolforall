<?php
require_once __DIR__ . '/../config/bootstrap.php';
Auth::exigerConnexion();

$pageActive = 'evenements';
$titrePage = 'Événements';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'creer') {
    $titre = trim($_POST['titre'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $date = $_POST['date_evenement'] ?? '';
    $lieu = trim($_POST['lieu'] ?? '');
    $nomImage = null;

    if (!empty($_FILES['image_couverture']['name'])) {
        $ext = strtolower(pathinfo($_FILES['image_couverture']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ALLOWED_IMAGE_EXTENSIONS)) {
            $nomImage = 'evenement_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['image_couverture']['tmp_name'], UPLOAD_PATH . 'evenements/' . $nomImage);
        }
    }

    if ($titre && $date) {
        $idEvenement = Evenement::creer($titre, $description, $date, $lieu, $nomImage);

        if (!empty($_FILES['galerie']['name'][0])) {
            foreach ($_FILES['galerie']['name'] as $index => $nomFichier) {
                if (!$nomFichier) continue;
                $ext = strtolower(pathinfo($nomFichier, PATHINFO_EXTENSION));
                if (in_array($ext, ALLOWED_IMAGE_EXTENSIONS)) {
                    $nomImageGalerie = 'galerie_' . time() . '_' . $index . '.' . $ext;
                    move_uploaded_file($_FILES['galerie']['tmp_name'][$index], UPLOAD_PATH . 'evenements/' . $nomImageGalerie);
                    Evenement::ajouterImageGalerie($idEvenement, $nomImageGalerie);
                }
            }
        }
        $message = 'Événement créé avec succès.';
    }
}

if (isset($_GET['supprimer'])) {
    Evenement::supprimer((int)$_GET['supprimer']);
    header('Location: evenements.php'); exit;
}

$evenements = Evenement::tous();
require __DIR__ . '/includes/admin-header.php';
?>

<?php if ($message): ?><div class="alert alert-success"><?= htmlspecialchars($message) ?></div><?php endif; ?>

<div class="card border-0 shadow-sm p-4 mb-4">
  <h6 class="fw-bold mb-3">Créer un événement</h6>
  <form method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="creer">
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Titre</label>
        <input type="text" class="form-control" name="titre" required>
      </div>
      <div class="col-md-3">
        <label class="form-label">Date</label>
        <input type="date" class="form-control" name="date_evenement" required>
      </div>
      <div class="col-md-3">
        <label class="form-label">Lieu</label>
        <input type="text" class="form-control" name="lieu">
      </div>
      <div class="col-12">
        <label class="form-label">Description</label>
        <textarea class="form-control" name="description" rows="3"></textarea>
      </div>
      <div class="col-md-6">
        <label class="form-label">Image de couverture</label>
        <input type="file" class="form-control" name="image_couverture" accept="image/*">
      </div>
      <div class="col-md-6">
        <label class="form-label">Galerie photos (plusieurs fichiers)</label>
        <input type="file" class="form-control" name="galerie[]" accept="image/*" multiple>
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-sfa-primary">Créer l'événement</button>
      </div>
    </div>
  </form>
</div>

<div class="card border-0 shadow-sm p-4">
  <h6 class="fw-bold mb-3">Événements créés</h6>
  <table class="table align-middle">
    <thead><tr><th>Titre</th><th>Date</th><th>Lieu</th><th>Actions</th></tr></thead>
    <tbody>
      <?php foreach ($evenements as $e): ?>
        <tr>
          <td><?= htmlspecialchars($e['titre']) ?></td>
          <td><?= date('d/m/Y', strtotime($e['date_evenement'])) ?></td>
          <td><?= htmlspecialchars($e['lieu'] ?? '') ?></td>
          <td><a href="evenements.php?supprimer=<?= $e['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer ?')"><i class="bi bi-trash"></i></a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php require __DIR__ . '/includes/admin-footer.php'; ?>

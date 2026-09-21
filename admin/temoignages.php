<?php
require_once __DIR__ . '/../config/bootstrap.php';
Auth::exigerConnexion();

$pageActive = 'temoignages';
$titrePage = 'Témoignages';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'creer') {
    $nomAuteur = trim($_POST['nom_auteur'] ?? '');
    $statut = trim($_POST['statut'] ?? '');
    $contenu = trim($_POST['contenu'] ?? '');
    $nomPhoto = null;

    if (!empty($_FILES['photo']['name'])) {
        $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ALLOWED_IMAGE_EXTENSIONS)) {
            $nomPhoto = 'temoignage_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['photo']['tmp_name'], UPLOAD_PATH . 'photos/' . $nomPhoto);
        }
    }

    if ($nomAuteur && $contenu) {
        Temoignage::creer($nomAuteur, $statut, $contenu, $nomPhoto);
        $message = 'Témoignage ajouté avec succès.';
    }
}

if (isset($_GET['supprimer'])) {
    Temoignage::supprimer((int)$_GET['supprimer']);
    header('Location: temoignages.php'); exit;
}

$temoignages = Temoignage::tous();
require __DIR__ . '/includes/admin-header.php';
?>

<?php if ($message): ?><div class="alert alert-success"><?= htmlspecialchars($message) ?></div><?php endif; ?>

<div class="card border-0 shadow-sm p-4 mb-4">
  <h6 class="fw-bold mb-3">Ajouter un témoignage</h6>
  <form method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="creer">
    <div class="row g-3">
      <div class="col-md-4">
        <label class="form-label">Nom</label>
        <input type="text" class="form-control" name="nom_auteur" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">Statut (ex : Bachelier 2026)</label>
        <input type="text" class="form-control" name="statut">
      </div>
      <div class="col-md-4">
        <label class="form-label">Photo</label>
        <input type="file" class="form-control" name="photo" accept="image/*">
      </div>
      <div class="col-12">
        <label class="form-label">Témoignage</label>
        <textarea class="form-control" name="contenu" rows="3" required></textarea>
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-sfa-primary">Ajouter</button>
      </div>
    </div>
  </form>
</div>

<div class="card border-0 shadow-sm p-4">
  <h6 class="fw-bold mb-3">Témoignages publiés</h6>
  <?php foreach ($temoignages as $t): ?>
    <div class="d-flex justify-content-between align-items-start border-bottom py-2">
      <div>
        <p class="fw-semibold mb-0"><?= htmlspecialchars($t['nom_auteur']) ?> <span class="text-secondary small"><?= htmlspecialchars($t['statut'] ?? '') ?></span></p>
        <p class="small mb-0"><?= htmlspecialchars($t['contenu']) ?></p>
      </div>
      <a href="temoignages.php?supprimer=<?= $t['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer ?')"><i class="bi bi-trash"></i></a>
    </div>
  <?php endforeach; ?>
</div>

<?php require __DIR__ . '/includes/admin-footer.php'; ?>

<?php
require_once __DIR__ . '/../config/bootstrap.php';
$pageActive = 'evenements';
$id = (int)($_GET['id'] ?? 0);
$evenement = Evenement::trouver($id);
$galerie = $evenement ? Evenement::galerie($id) : [];
require __DIR__ . '/includes/header.php';
?>
<section class="container py-5">
  <?php if (!$evenement): ?>
    <p class="text-secondary">Événement introuvable. <a href="evenements.php">Retour aux événements</a></p>
  <?php else: ?>
    <a href="evenements.php" class="small"><i class="bi bi-arrow-left"></i> Retour aux événements</a>
    <h1 class="fw-bold mt-3"><?= htmlspecialchars($evenement['titre']) ?></h1>
    <p class="text-secondary">
      <i class="bi bi-calendar-event"></i> <?= date('d/m/Y', strtotime($evenement['date_evenement'])) ?>
      &nbsp; <i class="bi bi-geo-alt"></i> <?= htmlspecialchars($evenement['lieu'] ?? '') ?>
    </p>
    <img src="<?= htmlspecialchars($evenement['image_couverture'] ? UPLOAD_URL . 'evenements/' . $evenement['image_couverture'] : 'https://placehold.co/900x400?text=' . urlencode($evenement['titre'])) ?>"
         class="img-fluid rounded-4 my-4" alt="">
    <p><?= nl2br(htmlspecialchars($evenement['description'] ?? '')) ?></p>

    <?php if ($galerie): ?>
      <h5 class="fw-bold mt-5 mb-3">Galerie photos</h5>
      <div class="row g-3">
        <?php foreach ($galerie as $img): ?>
          <div class="col-md-3 col-6">
            <img src="<?= htmlspecialchars(UPLOAD_URL . 'evenements/' . $img['chemin_image']) ?>" class="img-fluid rounded-3" alt="">
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  <?php endif; ?>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>

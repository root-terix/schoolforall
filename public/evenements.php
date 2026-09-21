<?php
require_once __DIR__ . '/../config/bootstrap.php';
$pageActive = 'evenements';
$aVenir = Evenement::aVenir();
$passes = Evenement::passes();
require __DIR__ . '/includes/header.php';
?>
<section class="container py-5">
  <h1 class="fw-bold mb-3">Nos événements</h1>
  <p class="text-secondary fs-5 mb-5">Découvrez les prochaines activités, compétitions, cérémonies et rendez-vous de SCHOOL FOR ALL.</p>

  <h4 class="fw-bold mb-3">Prochains événements</h4>
  <div class="row g-4 mb-5">
    <?php if (empty($aVenir)): ?>
      <p class="text-secondary">Aucun événement à venir pour le moment.</p>
    <?php endif; ?>
    <?php foreach ($aVenir as $e): ?>
      <div data-aos="fade-up" data-aos-delay="0" class="col-md-4">
        <div class="card sfa-post-card h-100">
          <img src="<?= htmlspecialchars($e['image_couverture'] ? UPLOAD_URL . 'evenements/' . $e['image_couverture'] : 'https://placehold.co/400x220?text=' . urlencode($e['titre'])) ?>"
               class="card-img-top" style="height:180px;object-fit:cover" alt="">
          <div class="card-body">
            <h6 class="fw-bold"><?= htmlspecialchars($e['titre']) ?></h6>
            <p class="small text-secondary mb-1"><i class="bi bi-calendar-event"></i> <?= date('d/m/Y', strtotime($e['date_evenement'])) ?></p>
            <p class="small text-secondary mb-2"><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($e['lieu'] ?? '') ?></p>
            <a href="evenement-detail.php?id=<?= $e['id'] ?>" class="btn btn-sfa-outline btn-sm">En savoir plus</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <h4 class="fw-bold mb-3">Événements passés — Galerie</h4>
  <div class="row g-4">
    <?php if (empty($passes)): ?>
      <p class="text-secondary">Aucun événement passé pour le moment.</p>
    <?php endif; ?>
    <?php foreach ($passes as $e): ?>
      <div data-aos="fade-up" data-aos-delay="80" class="col-md-4">
        <div class="card sfa-post-card h-100">
          <img src="<?= htmlspecialchars($e['image_couverture'] ? UPLOAD_URL . 'evenements/' . $e['image_couverture'] : 'https://placehold.co/400x220?text=' . urlencode($e['titre'])) ?>"
               class="card-img-top" style="height:180px;object-fit:cover" alt="">
          <div class="card-body">
            <h6 class="fw-bold"><?= htmlspecialchars($e['titre']) ?></h6>
            <p class="small text-secondary mb-2"><i class="bi bi-calendar-event"></i> <?= date('d/m/Y', strtotime($e['date_evenement'])) ?></p>
            <a href="evenement-detail.php?id=<?= $e['id'] ?>" class="btn btn-sfa-outline btn-sm">Voir la galerie</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>

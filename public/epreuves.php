<?php
require_once __DIR__ . '/../config/bootstrap.php';
$pageActive = 'epreuves';
$typeFiltre = $_GET['type'] ?? '';
$epreuves = Epreuve::tous($typeFiltre ?: null);
require __DIR__ . '/includes/header.php';

function abregeExamen($type) {
    $abrev = ['BEPC' => 'BEPC', 'Probatoire' => 'PROBA', 'Baccalaureat' => 'BAC', 'ETNS' => 'ETNS'];
    return $abrev[$type] ?? $type;
}
?>
<section class="container py-5" style="max-width:760px;">
  <div class="text-center mb-4" data-aos="fade-up">
    <span class="badge-pill">RESSOURCES</span>
    <h1 class="fw-bold mt-3">Épreuves & sujets d'examens</h1>
    <p class="text-secondary">Anciens sujets et corrigés du BEPC, du Probatoire, du Baccalauréat et de l'ETNS.</p>
  </div>

  <div class="d-flex gap-2 flex-wrap justify-content-center mb-4" data-aos="fade-up">
    <a href="epreuves.php" class="btn btn-sm <?= $typeFiltre==='' ? 'btn-sfa-primary' : 'btn-sfa-outline' ?>">Tous</a>
    <?php foreach (['BEPC','Probatoire','Baccalaureat','ETNS'] as $t): ?>
      <a href="epreuves.php?type=<?= $t ?>" class="btn btn-sm <?= $typeFiltre===$t ? 'btn-sfa-primary' : 'btn-sfa-outline' ?>"><?= $t ?></a>
    <?php endforeach; ?>
  </div>

  <?php if (empty($epreuves)): ?>
    <p class="text-secondary text-center">Aucune épreuve disponible pour le moment.</p>
  <?php endif; ?>

  <?php foreach ($epreuves as $i => $ep): ?>
    <div class="sfa-fb-post" data-aos="fade-up" data-aos-delay="<?= min($i * 60, 300) ?>">
      <div class="sfa-fb-header">
        <div class="sfa-epreuve-thumb"><?= abregeExamen($ep['type_examen']) ?></div>
        <div class="sfa-fb-meta">
          <div class="fb-name"><?= htmlspecialchars($ep['matiere']) ?> — <?= htmlspecialchars($ep['type_examen']) ?></div>
          <div class="fb-time"><i class="bi bi-calendar3"></i> Session <?= $ep['annee'] ?></div>
        </div>
      </div>
      <div class="sfa-fb-body">
        Sujet <?= $ep['fichier_sujet'] ? '' : '(à venir) ' ?>et corrigé <?= $ep['fichier_corrige'] ? '' : '(à venir) ' ?>de <?= htmlspecialchars($ep['matiere']) ?>
        pour l'examen du <?= htmlspecialchars($ep['type_examen']) ?>, session <?= $ep['annee'] ?>.
      </div>
      <div class="sfa-fb-actions">
        <?php if ($ep['fichier_sujet']): ?>
          <a href="<?= UPLOAD_URL . 'epreuves/' . htmlspecialchars($ep['fichier_sujet']) ?>" download>
            <i class="bi bi-download"></i> Télécharger le sujet
          </a>
        <?php else: ?>
          <span class="text-secondary"><i class="bi bi-hourglass-split"></i> Sujet à venir</span>
        <?php endif; ?>
        <?php if ($ep['fichier_corrige']): ?>
          <a href="<?= UPLOAD_URL . 'epreuves/' . htmlspecialchars($ep['fichier_corrige']) ?>" download>
            <i class="bi bi-check2-square"></i> Télécharger le corrigé
          </a>
        <?php else: ?>
          <span class="text-secondary"><i class="bi bi-hourglass-split"></i> Corrigé à venir</span>
        <?php endif; ?>
      </div>
    </div>
  <?php endforeach; ?>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>

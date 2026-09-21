<?php
require_once __DIR__ . '/../config/bootstrap.php';
$pageActive = 'resultats';
$resultats = Resultat::tous();
$parAnnee = [];
foreach ($resultats as $r) { $parAnnee[$r['annee']][] = $r; }
krsort($parAnnee);
require __DIR__ . '/includes/header.php';
?>
<section class="container py-5">
  <h1 class="fw-bold mb-3">Nos résultats</h1>
  <p class="text-secondary fs-5 mb-5">Les taux de réussite de nos élèves aux examens officiels, année après année.</p>

  <?php if (empty($parAnnee)): ?>
    <p class="text-secondary">Aucun résultat publié pour le moment.</p>
  <?php endif; ?>

  <?php foreach ($parAnnee as $annee => $lignes): ?>
    <h5 class="fw-bold mt-4 mb-3">Session <?= $annee ?></h5>
    <div class="row g-3 mb-4">
      <?php foreach ($lignes as $r): ?>
        <div data-aos="fade-up" data-aos-delay="0" class="col-6 col-md-3">
          <div class="sfa-card text-center">
            <div class="fs-2 fw-bold" style="color:var(--sfa-pink)"><?= number_format($r['taux_reussite'], 0) ?>%</div>
            <div class="small text-uppercase fw-semibold"><?= htmlspecialchars($r['type_examen']) ?></div>
            <div class="small text-secondary">Taux de réussite</div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endforeach; ?>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>

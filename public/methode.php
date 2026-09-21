<?php
require_once __DIR__ . '/../config/bootstrap.php';
$pageActive = 'methode';
require __DIR__ . '/includes/header.php';
?>
<section class="container py-5">
  <span class="badge-pill">NOTRE DIFFÉRENCE</span>
  <h1 class="fw-bold mt-3 mb-3">La méthode SCHFL</h1>
  <p class="text-secondary fs-5 mb-5">
    SCHOOL FOR ALL ne se limite pas à de simples cours de répétition : nous accompagnons l'élève,
    mesurons son niveau, identifions ses difficultés, adaptons son apprentissage et suivons sa progression.
  </p>

  <div class="row g-4">
    <?php
    $etapes = [
      ['bi-search', 'Évaluation / diagnostic', "Un diagnostic initial permet d'identifier précisément le niveau et les difficultés de l'élève."],
      ['bi-clipboard-check', 'Test de niveau SCHFL', "Un test complet et standardisé mesure le niveau réel de l'élève dans chaque matière."],
      ['bi-book', 'Cours ciblés', "Des cours sont ensuite construits sur mesure, en fonction des besoins identifiés."],
      ['bi-pencil-square', 'Exercices et travaux pratiques', "Chaque notion est mise en pratique à travers des exercices ciblés."],
      ['bi-clipboard-data', 'Contrôles réguliers', "Des évaluations fréquentes permettent de vérifier les acquis tout au long de l'année."],
      ['bi-graph-up-arrow', 'Suivi de la progression', "La progression de chaque élève est suivie et partagée avec les parents."],
      ['bi-award', 'Bilan pédagogique', "Un bilan analyse les résultats et propose un plan d'action pour progresser davantage."],
    ];
    foreach ($etapes as $i => $etape): ?>
      <div data-aos="fade-up" data-aos-delay="0" class="col-md-6">
        <div class="sfa-card d-flex gap-3 align-items-start">
          <div class="sfa-card-icon flex-shrink-0"><i class="bi <?= $etape[0] ?>"></i></div>
          <div>
            <h6 class="fw-bold mb-1">Étape <?= $i + 1 ?> — <?= $etape[1] ?></h6>
            <p class="small text-secondary mb-0"><?= $etape[2] ?></p>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>

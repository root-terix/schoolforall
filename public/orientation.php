<?php
require_once __DIR__ . '/../config/bootstrap.php';
$pageActive = 'orientation';
require __DIR__ . '/includes/header.php';
?>
<section class="container py-5">
  <h1 class="fw-bold mb-3">Parcours professionnel & orientation</h1>
  <p class="text-secondary fs-5 mb-5">SCHOOL FOR ALL accompagne aussi les jeunes et étudiants dans la construction de leur avenir.</p>

  <div class="row g-4">
    <?php
    $rubriques = [
      ['bi-trophy', 'Concours', "Concours d'entrée dans les grandes écoles et administrations.", 'concours'],
      ['bi-bank', 'Écoles & Universités', "Informations sur les établissements d'enseignement supérieur.", 'ecoles'],
      ['bi-briefcase', 'Emplois & Opportunités', "Offres d'emploi et opportunités professionnelles.", 'emplois'],
      ['bi-mortarboard', 'Stages académiques', "Stages en lien avec le cursus scolaire.", 'stages'],
      ['bi-building', 'Stages professionnels', "Immersions en entreprise pour découvrir un métier.", 'stages-pro'],
      ['bi-sun', 'Stages de vacances', "Programmes de renforcement pendant les vacances.", 'stages-vacances'],
      ['bi-cash-coin', 'Bourses d\'étude', "Bourses nationales et internationales disponibles.", 'bourses'],
    ];
    foreach ($rubriques as $r): ?>
      <div data-aos="fade-up" data-aos-delay="0" class="col-md-4 col-sm-6" id="<?= $r[3] ?>">
        <div class="sfa-card">
          <div class="sfa-card-icon"><i class="bi <?= $r[0] ?>"></i></div>
          <h6 class="fw-bold"><?= $r[1] ?></h6>
          <p class="small text-secondary mb-0"><?= $r[2] ?></p>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="sfa-cta-banner mt-5 d-flex flex-wrap justify-content-between align-items-center gap-3">
    <h5 class="fw-bold mb-0">Besoin d'aide pour vous orienter ?</h5>
    <a href="contact.php" class="btn btn-light fw-semibold">Contactez-nous</a>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>

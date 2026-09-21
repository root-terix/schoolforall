<?php
require_once __DIR__ . '/../config/bootstrap.php';
$pageActive = 'cours';
require __DIR__ . '/includes/header.php';
?>
<section class="container py-5">
  <h1 class="fw-bold mb-3">Nos cours</h1>
  <p class="text-secondary fs-5 mb-5">Un accompagnement complet, de la 6ème à la Terminale, adapté à chaque profil d'élève.</p>

  <div class="row g-4 mb-5">
    <div data-aos="fade-up" data-aos-delay="0" class="col-md-3 col-6">
      <div class="sfa-card">
        <div class="sfa-card-icon"><i class="bi bi-layers-fill"></i></div>
        <h6 class="fw-bold">Cours par niveau</h6>
        <p class="small text-secondary mb-0">De la 6ème à la Terminale, dans toutes les matières.</p>
      </div>
    </div>
    <div data-aos="fade-up" data-aos-delay="80" class="col-md-3 col-6">
      <div class="sfa-card">
        <div class="sfa-card-icon"><i class="bi bi-person-check-fill"></i></div>
        <h6 class="fw-bold">Accompagnement personnalisé</h6>
        <p class="small text-secondary mb-0">Un suivi individuel selon le rythme de l'élève.</p>
      </div>
    </div>
    <div data-aos="fade-up" data-aos-delay="160" class="col-md-3 col-6" id="stages">
      <div class="sfa-card">
        <div class="sfa-card-icon"><i class="bi bi-sun-fill"></i></div>
        <h6 class="fw-bold">Stages</h6>
        <p class="small text-secondary mb-0">Stages de vacances et de renforcement.</p>
      </div>
    </div>
    <div data-aos="fade-up" data-aos-delay="240" class="col-md-3 col-6">
      <div class="sfa-card">
        <div class="sfa-card-icon"><i class="bi bi-clipboard-check-fill"></i></div>
        <h6 class="fw-bold">Préparation aux examens</h6>
        <p class="small text-secondary mb-0">BEPC, Probatoire, Baccalauréat, ETNS.</p>
      </div>
    </div>
  </div>

  <h3 class="fw-bold mb-3" id="niveaux">Niveaux disponibles</h3>
  <div class="row g-3">
    <?php foreach (['6ème','5ème','4ème','3ème','2nde','1ère','Terminale'] as $niveau): ?>
      <div class="col-6 col-md-3 col-lg-2">
        <div class="text-center border rounded-3 py-4 fw-semibold"><?= $niveau ?></div>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="sfa-cta-banner mt-5 d-flex flex-wrap justify-content-between align-items-center gap-3">
    <h5 class="fw-bold mb-0">Intéressé par un niveau ou une matière en particulier ?</h5>
    <a href="inscription.php" class="btn btn-light fw-semibold">S'inscrire maintenant</a>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>

<?php
require_once __DIR__ . '/../config/bootstrap.php';

$pageActive = 'accueil';

$resultats    = Resultat::dernierAnnee();
$temoignages  = Temoignage::tous();
$evenements   = array_slice(Evenement::aVenir(), 0, 3);

require __DIR__ . '/includes/header.php';
?>

<!-- HERO -->
<section class="sfa-hero">
  <span class="sfa-shape sfa-shape-1" style="width:90px;height:90px;background:var(--sfa-grad-2);top:10%;left:4%;"></span>
  <span class="sfa-shape sfa-shape-2" style="width:60px;height:60px;background:var(--sfa-grad-1);top:65%;left:12%;"></span>
  <span class="sfa-shape sfa-shape-3" style="width:130px;height:130px;border:3px dashed var(--sfa-pink);background:transparent;top:15%;right:6%;"></span>
  <span class="sfa-shape sfa-shape-1" style="width:40px;height:40px;background:var(--sfa-grad-3);bottom:8%;right:18%;"></span>
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6" data-aos="fade-right">
        <span class="badge-pill">SCHOOL FOR ALL</span>
        <h1 class="mt-3">Votre réussite <span style="color:var(--sfa-pink)">commence ici !</span></h1>
        <p class="text-secondary fs-5">Un accompagnement scolaire de qualité, de la 6ème à la Terminale, pour révéler le potentiel de chaque élève.</p>
        <div class="d-flex gap-3 flex-wrap mt-4">
          <a href="inscription.php" class="btn btn-sfa-primary btn-lg"><i class="bi bi-pencil-square"></i> S'inscrire maintenant</a>
          <a href="cours.php" class="btn btn-sfa-outline btn-lg">Découvrir nos cours <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="row mt-5 g-3 small">
          <div class="col-6" data-aos="fade-up" data-aos-delay="100"><i class="bi bi-mortarboard-fill text-danger"></i> Enseignants qualifiés</div>
          <div class="col-6" data-aos="fade-up" data-aos-delay="200"><i class="bi bi-graph-up-arrow text-danger"></i> Suivi personnalisé</div>
          <div class="col-6" data-aos="fade-up" data-aos-delay="300"><i class="bi bi-award-fill text-danger"></i> Méthode éprouvée</div>
          <div class="col-6" data-aos="fade-up" data-aos-delay="400"><i class="bi bi-bar-chart-fill text-danger"></i> Résultats excellents</div>
        </div>
      </div>
      <div class="col-lg-6 text-center sfa-hero-3d-wrap position-relative" data-aos="zoom-in" data-aos-delay="150">
        <span class="sfa-hero-dots" style="top:-10px; left:-10px;"></span>
        <i class="bi bi-mortarboard-fill sfa-hero-icon-float" style="font-size:2.2rem; top:5%; right:8%; animation-delay:.3s;"></i>
        <i class="bi bi-book-half sfa-hero-icon-float" style="font-size:1.8rem; bottom:12%; left:2%; animation-delay:1.1s;"></i>
        <i class="bi bi-stars sfa-hero-icon-float" style="font-size:1.5rem; top:38%; right:-2%; animation-delay:.6s;"></i>
        <img src="assets/img/eleve.jpg" onerror="this.style.display='none'" class="img-fluid sfa-hero-3d-img" alt="Élèves SCHOOL FOR ALL">
      </div>
    </div>
  </div>
</section>

<!-- POURQUOI NOUS CHOISIR -->
<section class="py-5" style="background: linear-gradient(180deg, var(--sfa-pink-light) 0%, #fff 100%);">
  <div class="container">
  <div class="row g-4">
    <div class="col-lg-6" data-aos="fade-right">
      <h2 class="fw-bold mb-4">Pourquoi nous choisir ?</h2>
      <div class="row g-3">
        <div class="col-6" data-aos="flip-left" data-aos-delay="0">
          <div class="sfa-glass-card">
            <div class="sfa-card-icon"><i class="bi bi-people-fill"></i></div>
            <h6 class="fw-bold">Enseignants qualifiés</h6>
            <p class="small text-secondary mb-0">Des enseignants expérimentés et passionnés par la réussite de leurs élèves.</p>
          </div>
        </div>
        <div class="col-6" data-aos="flip-left" data-aos-delay="100">
          <div class="sfa-glass-card">
            <div class="sfa-card-icon"><i class="bi bi-bullseye"></i></div>
            <h6 class="fw-bold">Suivi personnalisé</h6>
            <p class="small text-secondary mb-0">Chaque élève bénéficie d'un suivi individuel pour une progression constante.</p>
          </div>
        </div>
        <div class="col-6" data-aos="flip-left" data-aos-delay="200">
          <div class="sfa-glass-card">
            <div class="sfa-card-icon"><i class="bi bi-graph-up"></i></div>
            <h6 class="fw-bold">Méthode éprouvée</h6>
            <p class="small text-secondary mb-0">La méthode SCHFL, une démarche structurée et efficace.</p>
          </div>
        </div>
        <div class="col-6" data-aos="flip-left" data-aos-delay="300">
          <div class="sfa-glass-card">
            <div class="sfa-card-icon"><i class="bi bi-trophy-fill"></i></div>
            <h6 class="fw-bold">Excellents résultats</h6>
            <p class="small text-secondary mb-0">Des taux de réussite aux examens officiels d'année en année.</p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-6" id="niveaux" data-aos="fade-left">
      <h2 class="fw-bold mb-4">De la 6ème à la Terminale</h2>
      <div class="row g-2 mb-3">
        <?php foreach (['6ème','5ème','4ème','3ème','2nde','1ère'] as $niveau): ?>
          <div class="col-3"><div class="sfa-niveau-pill"><?= $niveau ?></div></div>
        <?php endforeach; ?>
        <div class="col-3"><div class="sfa-niveau-pill active">Terminale</div></div>
      </div>
      <div class="border-start border-3 border-danger ps-3">
        <p class="fw-semibold mb-1">Tous les niveaux. Toutes les matières.</p>
        <p class="text-secondary small">Un accompagnement complet pour aider chaque élève à atteindre l'excellence.</p>
      </div>
      <a href="cours.php" class="btn btn-sfa-primary mt-2">Voir les cours par niveau <i class="bi bi-arrow-right"></i></a>
    </div>
  </div>
  </div>
</section>

<!-- METHODE SCHFL -->
<section class="py-5" style="background:var(--sfa-pink-light)">
  <div class="container">
    <h2 class="text-center fw-bold mb-5" data-aos="fade-up">Notre méthode <span style="color:var(--sfa-pink)">SCHFL</span></h2>
    <div class="row g-4 text-center sfa-methode-timeline">
      <?php
      $etapes = [
        ['bi-search', 'Diagnostic', "Évaluation initiale pour identifier le niveau et les difficultés.", 'mc-1'],
        ['bi-clipboard-check', 'Test de niveau SCHFL', "Test complet pour mesurer le niveau réel de l'élève.", 'mc-2'],
        ['bi-book', 'Cours ciblés', "Cours adaptés aux besoins spécifiques de l'élève.", 'mc-3'],
        ['bi-pencil', 'Exercices & TP', "Mise en pratique à travers des exercices et travaux pratiques.", 'mc-4'],
        ['bi-clipboard-data', 'Contrôles réguliers', "Évaluations fréquentes pour vérifier les acquis.", 'mc-5'],
        ['bi-graph-up-arrow', 'Suivi de progression', "Suivi constant de l'évolution de l'élève.", 'mc-6'],
        ['bi-award', 'Bilan pédagogique', "Analyse des résultats et plan d'action pour aller plus loin.", 'mc-7'],
      ];
      foreach ($etapes as $i => $etape): ?>
        <div class="col-6 col-md-3 col-lg" data-aos="zoom-in-up" data-aos-delay="<?= $i * 80 ?>">
          <div class="sfa-methode-step">
            <div class="sfa-methode-circle <?= $etape[3] ?>" style="animation-delay:<?= $i * 0.1 ?>s"><i class="bi <?= $etape[0] ?>"></i></div>
            <h6 class="fw-bold"><?= $etape[1] ?></h6>
            <p class="small text-secondary"><?= $etape[2] ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- RESULTATS / TEMOIGNAGES / EVENEMENTS -->
<section class="container py-5">
  <div class="row g-4">
    <div class="col-lg-4" data-aos="fade-up">
      <h5 class="fw-bold mb-3">Nos résultats</h5>
      <div class="row g-2">
        <?php $couleurs = ['c-pink','c-blue','c-yellow','c-teal']; ?>
        <?php foreach ($resultats as $i => $r): ?>
          <div class="col-6">
            <div class="sfa-resultat-tile <?= $couleurs[$i % 4] ?>">
              <div class="valeur"><span class="sfa-counter" data-valeur="<?= (float)$r['taux_reussite'] ?>" data-suffixe="%">0%</span></div>
              <div class="small text-uppercase fw-semibold"><?= htmlspecialchars($r['type_examen']) ?> <?= $r['annee'] ?></div>
              <div class="small text-secondary">Taux de réussite</div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <a href="resultats.php" class="d-block mt-3 fw-semibold">Voir tous les résultats <i class="bi bi-arrow-right"></i></a>
    </div>

    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="150">
      <h5 class="fw-bold mb-3">Témoignages</h5>
      <?php if ($temoignages): ?>
        <div id="carouselTemoignages" class="carousel slide">
          <div class="carousel-inner">
            <?php foreach ($temoignages as $i => $t): ?>
              <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                <div class="sfa-testimonial-card">
                  <i class="bi bi-quote fs-2" style="color:var(--sfa-pink)"></i>
                  <p class="fst-italic small"><?= htmlspecialchars($t['contenu']) ?></p>
                  <div class="d-flex align-items-center gap-2 mt-3">
                    <div class="sfa-fb-avatar" style="width:38px;height:38px;font-size:.8rem;"><?= strtoupper(mb_substr($t['nom_auteur'],0,1)) ?></div>
                    <div>
                      <p class="fw-bold mb-0 small"><?= htmlspecialchars($t['nom_auteur']) ?></p>
                      <p class="text-secondary small mb-0"><?= htmlspecialchars($t['statut'] ?? '') ?></p>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
          <?php if (count($temoignages) > 1): ?>
            <div class="d-flex justify-content-between align-items-center mt-3">
              <button class="sfa-testimonial-nav" type="button" data-bs-target="#carouselTemoignages" data-bs-slide="prev">
                <i class="bi bi-chevron-left"></i>
              </button>
              <div class="sfa-testimonial-dots">
                <?php foreach ($temoignages as $i => $t): ?>
                  <span class="<?= $i === 0 ? 'active' : '' ?>"></span>
                <?php endforeach; ?>
              </div>
              <button class="sfa-testimonial-nav" type="button" data-bs-target="#carouselTemoignages" data-bs-slide="next">
                <i class="bi bi-chevron-right"></i>
              </button>
            </div>
          <?php endif; ?>
        </div>
      <?php else: ?>
        <p class="text-secondary small">Aucun témoignage pour le moment.</p>
      <?php endif; ?>
    </div>

    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
      <h5 class="fw-bold mb-3">Prochains événements</h5>
      <?php foreach ($evenements as $e): ?>
        <div class="sfa-event-row">
          <div class="sfa-event-thumb">
            <?php if (!empty($e['image_couverture'])): ?>
              <img src="<?= UPLOAD_URL . 'evenements/' . htmlspecialchars($e['image_couverture']) ?>" alt="">
            <?php else: ?>
              <i class="bi bi-mortarboard-fill" style="color:var(--sfa-pink); font-size:1.3rem;"></i>
            <?php endif; ?>
          </div>
          <div class="flex-grow-1">
            <p class="fw-semibold mb-0 small"><?= htmlspecialchars($e['titre']) ?></p>
            <p class="text-secondary small mb-0"><i class="bi bi-calendar3"></i> <?= date('d/m/Y', strtotime($e['date_evenement'])) ?> · <i class="bi bi-geo-alt"></i> <?= htmlspecialchars($e['lieu'] ?? '') ?></p>
          </div>
          <a href="evenement-detail.php?id=<?= $e['id'] ?>" class="sfa-btn-savoir-plus">EN SAVOIR PLUS</a>
        </div>
      <?php endforeach; ?>
      <a href="evenements.php" class="d-block mt-3 fw-semibold">Voir tous les événements <i class="bi bi-arrow-right"></i></a>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="container pb-5">
  <div class="sfa-cta-banner d-flex flex-wrap justify-content-between align-items-center gap-3" data-aos="zoom-in">
    <div class="d-flex align-items-center gap-3">
      <div class="bg-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:52px;height:52px;">
        <i class="bi bi-mortarboard-fill fs-4" style="color:var(--sfa-pink)"></i>
      </div>
      <div>
        <h4 class="fw-bold mb-1">Prêt à faire progresser votre enfant ?</h4>
        <p class="mb-0">Rejoignez SCHOOL FOR ALL dès aujourd'hui !</p>
      </div>
    </div>
    <a href="inscription.php" class="btn btn-light fw-semibold"><i class="bi bi-pencil-square"></i> S'inscrire maintenant</a>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>

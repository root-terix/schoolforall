<?php
require_once __DIR__ . '/../config/bootstrap.php';
Auth::exigerConnexion();

$pageActive = 'dashboard';
$titrePage = 'Tableau de bord';

$nombreEleves = Eleve::compter();
$nombreArticles = count(Article::tous(false));
$nombreEpreuves = count(Epreuve::tous());
$nombreEvenementsAVenir = count(Evenement::aVenir());

$parMois = Eleve::parMois();
$parNiveau = Eleve::parNiveau();
$parStatut = Eleve::parStatut();
$parJour = Eleve::parJourSemaine();

// Préparation des données pour Chart.js
$moisLabels = array_map(fn($m) => $m['mois'], $parMois);
$moisValeurs = array_map(fn($m) => (int)$m['total'], $parMois);

$niveauLabels = array_map(fn($n) => $n['classe'], $parNiveau);
$niveauValeurs = array_map(fn($n) => (int)$n['total'], $parNiveau);

$nouveaux = 0; $anciens = 0;
foreach ($parStatut as $s) {
    if ($s['statut'] === 'nouveau') $nouveaux = (int)$s['total'];
    else $anciens = (int)$s['total'];
}

$joursLabels = ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'];
$joursValeurs = array_values($parJour);

require __DIR__ . '/includes/admin-header.php';
?>

<div class="row g-4 mb-4">
  <div class="col-md-3" data-aos="fade-up">
    <div class="sfa-stat-card">
      <div class="sfa-stat-icon"><i class="bi bi-people-fill"></i></div>
      <div class="sfa-stat-value"><?= $nombreEleves ?></div>
      <div class="sfa-stat-label">Élèves inscrits</div>
      <span class="sfa-stat-trend"><i class="bi bi-arrow-up-short"></i> Total cumulé</span>
    </div>
  </div>
  <div class="col-md-3" data-aos="fade-up" data-aos-delay="80">
    <div class="sfa-stat-card grad-2">
      <div class="sfa-stat-icon"><i class="bi bi-newspaper"></i></div>
      <div class="sfa-stat-value"><?= $nombreArticles ?></div>
      <div class="sfa-stat-label">Publications blog</div>
      <span class="sfa-stat-trend"><i class="bi bi-hand-thumbs-up"></i> Newsletter</span>
    </div>
  </div>
  <div class="col-md-3" data-aos="fade-up" data-aos-delay="160">
    <div class="sfa-stat-card grad-3">
      <div class="sfa-stat-icon"><i class="bi bi-file-earmark-text"></i></div>
      <div class="sfa-stat-value"><?= $nombreEpreuves ?></div>
      <div class="sfa-stat-label">Épreuves en ligne</div>
      <span class="sfa-stat-trend"><i class="bi bi-download"></i> Sujets & corrigés</span>
    </div>
  </div>
  <div class="col-md-3" data-aos="fade-up" data-aos-delay="240">
    <div class="sfa-stat-card grad-dark">
      <div class="sfa-stat-icon"><i class="bi bi-calendar-event"></i></div>
      <div class="sfa-stat-value"><?= $nombreEvenementsAVenir ?></div>
      <div class="sfa-stat-label">Événements à venir</div>
      <span class="sfa-stat-trend"><i class="bi bi-geo-alt"></i> Agenda</span>
    </div>
  </div>
</div>

<div class="row g-4 mb-4">
  <div class="col-lg-8" data-aos="fade-up">
    <div class="sfa-admin-card p-4">
      <div class="card-title-row">
        <h6 class="fw-bold mb-0">Évolution des inscriptions (6 derniers mois)</h6>
        <span class="badge" style="background:var(--sfa-pink-light); color:var(--sfa-pink-dark)">Élèves / mois</span>
      </div>
      <canvas id="graphInscriptions" height="90"></canvas>
    </div>
  </div>
  <div class="col-lg-4" data-aos="fade-up" data-aos-delay="120">
    <div class="sfa-admin-card p-4 h-100">
      <div class="card-title-row">
        <h6 class="fw-bold mb-0">Nouveaux vs Anciens</h6>
      </div>
      <canvas id="graphStatut" height="200"></canvas>
    </div>
  </div>
</div>

<div class="row g-4">
  <div class="col-lg-6" data-aos="fade-up">
    <div class="sfa-admin-card p-4">
      <div class="card-title-row">
        <h6 class="fw-bold mb-0">Élèves par niveau</h6>
      </div>
      <canvas id="graphNiveau" height="220"></canvas>
    </div>
  </div>
  <div class="col-lg-6" data-aos="fade-up" data-aos-delay="120">
    <div class="sfa-admin-card p-4">
      <div class="card-title-row">
        <h6 class="fw-bold mb-0">Inscriptions par jour de la semaine</h6>
      </div>
      <canvas id="graphJours" height="220"></canvas>
    </div>
  </div>
</div>

<div class="sfa-admin-card p-4 mt-4" data-aos="fade-up">
  <h6 class="fw-bold mb-2">Bienvenue, <?= htmlspecialchars(Auth::nomAdmin()) ?> 👋</h6>
  <p class="text-secondary mb-0">
    Utilisez le menu latéral pour gérer les publications du blog, les épreuves et corrigés,
    les inscriptions des élèves, les témoignages, les résultats, le planning, les tarifs,
    les événements et l'écosystème de l'équipe pédagogique.
  </p>
</div>

<script>
const couleurPink = '#EC4899';
const degradePink = (ctx) => {
  const g = ctx.chart.ctx.createLinearGradient(0, 0, 0, 260);
  g.addColorStop(0, 'rgba(236,72,153,0.35)');
  g.addColorStop(1, 'rgba(236,72,153,0)');
  return g;
};

new Chart(document.getElementById('graphInscriptions'), {
  type: 'line',
  data: {
    labels: <?= json_encode($moisLabels) ?>,
    datasets: [{
      label: 'Inscriptions',
      data: <?= json_encode($moisValeurs) ?>,
      borderColor: couleurPink,
      backgroundColor: degradePink,
      fill: true,
      tension: 0.4,
      pointBackgroundColor: '#fff',
      pointBorderColor: couleurPink,
      pointBorderWidth: 2,
      pointRadius: 5,
    }]
  },
  options: {
    plugins: { legend: { display: false } },
    scales: { y: { beginAtZero: true, ticks: { precision: 0 } } },
    animation: { duration: 1200, easing: 'easeOutQuart' }
  }
});

new Chart(document.getElementById('graphStatut'), {
  type: 'doughnut',
  data: {
    labels: ['Nouveaux', 'Anciens'],
    datasets: [{
      data: [<?= $nouveaux ?>, <?= $anciens ?>],
      backgroundColor: ['#EC4899', '#831843'],
      borderWidth: 0,
    }]
  },
  options: {
    cutout: '70%',
    plugins: { legend: { position: 'bottom' } },
    animation: { animateRotate: true, duration: 1200 }
  }
});

new Chart(document.getElementById('graphNiveau'), {
  type: 'doughnut',
  data: {
    labels: <?= json_encode($niveauLabels) ?>,
    datasets: [{
      data: <?= json_encode($niveauValeurs) ?>,
      backgroundColor: ['#F472B6','#EC4899','#C026D3','#831843','#FB7185','#E879F9','#9D174D'],
      borderWidth: 0,
    }]
  },
  options: {
    cutout: '60%',
    plugins: { legend: { position: 'bottom' } },
    animation: { animateRotate: true, duration: 1200 }
  }
});

new Chart(document.getElementById('graphJours'), {
  type: 'bar',
  data: {
    labels: <?= json_encode($joursLabels) ?>,
    datasets: [{
      label: 'Inscriptions',
      data: <?= json_encode($joursValeurs) ?>,
      backgroundColor: '#EC4899',
      borderRadius: 8,
      maxBarThickness: 34,
    }]
  },
  options: {
    plugins: { legend: { display: false } },
    scales: { y: { beginAtZero: true, ticks: { precision: 0 } } },
    animation: { duration: 1200, easing: 'easeOutQuart' }
  }
});
</script>

<?php require __DIR__ . '/includes/admin-footer.php'; ?>

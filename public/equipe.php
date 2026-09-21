<?php
require_once __DIR__ . '/../config/bootstrap.php';
$pageActive = 'equipe';
$arbre = Enseignant::arbreHierarchique();
$leader = $arbre[0] ?? null;
$autresRacines = array_slice($arbre, 1);
require __DIR__ . '/includes/header.php';

function initiales($nom) {
    $mots = preg_split('/\s+/', trim($nom));
    $init = '';
    foreach (array_slice($mots, 0, 2) as $m) { $init .= mb_substr($m, 0, 1); }
    return mb_strtoupper($init);
}
?>
<section class="container py-5">
  <div class="text-center mb-5" data-aos="fade-up">
    <span class="badge-pill">ÉCOSYSTÈME SCHOOL FOR ALL</span>
    <h1 class="fw-bold mt-3">Notre équipe pédagogique</h1>
    <p class="text-secondary fs-5">Une équipe organisée autour d'une direction pédagogique, connectée pour accompagner chaque élève.</p>
  </div>

  <?php if (!$leader): ?>
    <p class="text-secondary text-center">L'équipe pédagogique sera bientôt présentée ici. Contenu géré depuis le tableau de bord administrateur.</p>
  <?php else: ?>
    <div class="sfa-ecosystem" id="zoneEcosysteme">
      <svg class="sfa-eco-svg" id="svgLiens"></svg>

      <!-- Dirigeant (centre) -->
      <div class="sfa-eco-leader" id="nodeLeader" data-aos="zoom-in">
        <?php if (!empty($leader['photo'])): ?>
          <img src="<?= UPLOAD_URL . 'photos/' . htmlspecialchars($leader['photo']) ?>" class="eco-photo" alt="">
        <?php else: ?>
          <div class="eco-photo d-flex align-items-center justify-content-center bg-white fw-bold" style="color:var(--sfa-pink)"><?= initiales($leader['nom_complet']) ?></div>
        <?php endif; ?>
        <div class="eco-name"><?= htmlspecialchars($leader['nom_complet']) ?></div>
        <div class="eco-role"><?= htmlspecialchars($leader['poste'] ?? 'Direction') ?></div>
      </div>

      <!-- Équipe connectée -->
      <div class="row g-4 mt-4 justify-content-center sfa-eco-branch" id="zoneNoeuds">
        <?php foreach (($leader['equipe'] ?? []) as $i => $membre): ?>
          <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
            <div class="sfa-eco-node eco-item">
              <?php if (!empty($membre['photo'])): ?>
                <img src="<?= UPLOAD_URL . 'photos/' . htmlspecialchars($membre['photo']) ?>" class="eco-photo" alt="">
              <?php else: ?>
                <div class="eco-photo d-flex align-items-center justify-content-center fw-bold" style="background:var(--sfa-pink-light); color:var(--sfa-pink-dark)"><?= initiales($membre['nom_complet']) ?></div>
              <?php endif; ?>
              <p class="eco-name mb-0"><?= htmlspecialchars($membre['nom_complet']) ?></p>
              <p class="eco-role mb-0"><?= htmlspecialchars($membre['poste'] ?? 'Enseignant') ?></p>
              <p class="eco-matiere mb-0"><?= htmlspecialchars($membre['matiere']) ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <script>
      // Dessine dynamiquement les liens SVG entre le dirigeant (centre) et chaque membre de l'équipe,
      // pour un rendu "écosystème" qui s'adapte à la taille de l'écran.
      function dessinerLiensEcosysteme() {
        const zone = document.getElementById('zoneEcosysteme');
        const svg = document.getElementById('svgLiens');
        const leader = document.getElementById('nodeLeader');
        const noeuds = document.querySelectorAll('.eco-item');
        if (!zone || !leader || !noeuds.length) return;

        const zoneRect = zone.getBoundingClientRect();
        const leaderRect = leader.getBoundingClientRect();
        const xLeader = leaderRect.left + leaderRect.width / 2 - zoneRect.left;
        const yLeader = leaderRect.top + leaderRect.height / 2 - zoneRect.top;

        svg.innerHTML = '';
        noeuds.forEach(function (noeud) {
          const r = noeud.getBoundingClientRect();
          const xNoeud = r.left + r.width / 2 - zoneRect.left;
          const yNoeud = r.top - zoneRect.top;
          const chemin = document.createElementNS('http://www.w3.org/2000/svg', 'path');
          const milieuY = (yLeader + yNoeud) / 2;
          chemin.setAttribute('d', `M${xLeader},${yLeader} C${xLeader},${milieuY} ${xNoeud},${milieuY} ${xNoeud},${yNoeud}`);
          svg.appendChild(chemin);
        });
      }
      window.addEventListener('load', dessinerLiensEcosysteme);
      window.addEventListener('resize', dessinerLiensEcosysteme);
      setTimeout(dessinerLiensEcosysteme, 400);
    </script>
  <?php endif; ?>

  <?php if ($autresRacines): ?>
    <hr class="my-5">
    <h5 class="fw-bold mb-4">Autres membres</h5>
    <div class="row g-4">
      <?php foreach ($autresRacines as $membre): ?>
        <div class="col-md-4 col-sm-6" data-aos="fade-up">
          <div class="sfa-card text-center">
            <?php if (!empty($membre['photo'])): ?>
              <img src="<?= UPLOAD_URL . 'photos/' . htmlspecialchars($membre['photo']) ?>" class="rounded-circle mb-3" width="90" height="90" style="object-fit:cover" alt="">
            <?php endif; ?>
            <h6 class="fw-bold mb-0"><?= htmlspecialchars($membre['nom_complet']) ?></h6>
            <p class="small mb-0" style="color:var(--sfa-pink)"><?= htmlspecialchars($membre['matiere']) ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>

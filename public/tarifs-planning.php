<?php
require_once __DIR__ . '/../config/bootstrap.php';
$pageActive = 'tarifs';
$tarifs = Tarif::tous();
$planning = Planning::tous();
require __DIR__ . '/includes/header.php';
?>
<section class="container py-5">
  <h1 class="fw-bold mb-3">Tarifs & Planning</h1>
  <p class="text-secondary fs-5 mb-5">Toutes les informations pratiques pour organiser la scolarité de votre enfant chez SCHOOL FOR ALL.</p>

  <h4 class="fw-bold mb-3">Grille tarifaire</h4>
  <div class="table-responsive mb-5">
    <table class="table table-bordered align-middle">
      <thead class="table-dark">
        <tr><th>Niveau</th><th>Montant</th><th>Périodicité</th><th>Conditions particulières</th></tr>
      </thead>
      <tbody>
        <?php if (empty($tarifs)): ?>
          <tr><td colspan="4" class="text-secondary text-center">Tarifs à venir — contenu géré depuis le tableau de bord.</td></tr>
        <?php endif; ?>
        <?php foreach ($tarifs as $t): ?>
          <tr>
            <td class="fw-semibold"><?= htmlspecialchars($t['niveau']) ?></td>
            <td><?= number_format($t['montant'], 0, ',', ' ') ?> FCFA</td>
            <td><?= htmlspecialchars($t['periodicite']) ?></td>
            <td class="small text-secondary"><?= htmlspecialchars($t['conditions'] ?? '—') ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <h4 class="fw-bold mb-3">Planning des cours</h4>
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead class="table-dark">
        <tr><th>Niveau</th><th>Jour</th><th>Horaires</th><th>Lieu</th></tr>
      </thead>
      <tbody>
        <?php if (empty($planning)): ?>
          <tr><td colspan="4" class="text-secondary text-center">Planning à venir — contenu géré depuis le tableau de bord.</td></tr>
        <?php endif; ?>
        <?php foreach ($planning as $p): ?>
          <tr>
            <td class="fw-semibold"><?= htmlspecialchars($p['niveau']) ?></td>
            <td><?= htmlspecialchars($p['jour_semaine']) ?></td>
            <td><?= substr($p['heure_debut'],0,5) ?> — <?= substr($p['heure_fin'],0,5) ?></td>
            <td class="small text-secondary"><?= htmlspecialchars($p['lieu'] ?? '—') ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>

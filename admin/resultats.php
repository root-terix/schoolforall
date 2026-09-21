<?php
require_once __DIR__ . '/../config/bootstrap.php';
Auth::exigerConnexion();

$pageActive = 'resultats';
$titrePage = 'Résultats';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'creer') {
    $typeExamen = $_POST['type_examen'] ?? '';
    $annee = (int)($_POST['annee'] ?? 0);
    $taux = (float)($_POST['taux_reussite'] ?? 0);

    if ($typeExamen && $annee) {
        Resultat::enregistrer($typeExamen, $annee, $taux);
        $message = 'Résultat enregistré avec succès.';
    }
}

if (isset($_GET['supprimer'])) {
    Resultat::supprimer((int)$_GET['supprimer']);
    header('Location: resultats.php'); exit;
}

$resultats = Resultat::tous();
require __DIR__ . '/includes/admin-header.php';
?>

<?php if ($message): ?><div class="alert alert-success"><?= htmlspecialchars($message) ?></div><?php endif; ?>

<div class="card border-0 shadow-sm p-4 mb-4">
  <h6 class="fw-bold mb-3">Ajouter / mettre à jour un résultat</h6>
  <form method="post">
    <input type="hidden" name="action" value="creer">
    <div class="row g-3">
      <div class="col-md-4">
        <label class="form-label">Examen</label>
        <select class="form-select" name="type_examen" required>
          <option value="BEPC">BEPC</option>
          <option value="Probatoire">Probatoire</option>
          <option value="Baccalaureat">Baccalauréat</option>
          <option value="ETNS">ETNS</option>
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Année</label>
        <input type="number" class="form-control" name="annee" min="2000" max="2100" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">Taux de réussite (%)</label>
        <input type="number" step="0.01" class="form-control" name="taux_reussite" min="0" max="100" required>
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-sfa-primary">Enregistrer</button>
      </div>
    </div>
  </form>
</div>

<div class="card border-0 shadow-sm p-4">
  <h6 class="fw-bold mb-3">Résultats enregistrés</h6>
  <table class="table align-middle">
    <thead><tr><th>Examen</th><th>Année</th><th>Taux</th><th>Actions</th></tr></thead>
    <tbody>
      <?php foreach ($resultats as $r): ?>
        <tr>
          <td><?= htmlspecialchars($r['type_examen']) ?></td>
          <td><?= $r['annee'] ?></td>
          <td><?= number_format($r['taux_reussite'], 2) ?>%</td>
          <td><a href="resultats.php?supprimer=<?= $r['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer ?')"><i class="bi bi-trash"></i></a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php require __DIR__ . '/includes/admin-footer.php'; ?>

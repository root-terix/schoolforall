<?php
require_once __DIR__ . '/../config/bootstrap.php';
Auth::exigerConnexion();

$pageActive = 'planning';
$titrePage = 'Planning & Tarifs';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'creer_planning') {
    Planning::creer($_POST['niveau'], $_POST['jour_semaine'], $_POST['heure_debut'], $_POST['heure_fin'], $_POST['lieu'] ?? null);
    $message = 'Créneau ajouté au planning.';
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'creer_tarif') {
    Tarif::creer($_POST['niveau'], (float)$_POST['montant'], $_POST['periodicite'], $_POST['conditions'] ?? null);
    $message = 'Tarif ajouté.';
}
if (isset($_GET['supprimer_planning'])) {
    Planning::supprimer((int)$_GET['supprimer_planning']);
    header('Location: planning-tarifs.php'); exit;
}
if (isset($_GET['supprimer_tarif'])) {
    Tarif::supprimer((int)$_GET['supprimer_tarif']);
    header('Location: planning-tarifs.php'); exit;
}

$planning = Planning::tous();
$tarifs = Tarif::tous();
require __DIR__ . '/includes/admin-header.php';
?>

<?php if ($message): ?><div class="alert alert-success"><?= htmlspecialchars($message) ?></div><?php endif; ?>

<div class="row g-4">
  <div class="col-lg-6">
    <div class="card border-0 shadow-sm p-4 mb-4">
      <h6 class="fw-bold mb-3">Ajouter un créneau de planning</h6>
      <form method="post">
        <input type="hidden" name="action" value="creer_planning">
        <div class="row g-2">
          <div class="col-6"><input type="text" class="form-control" name="niveau" placeholder="Niveau" required></div>
          <div class="col-6">
            <select class="form-select" name="jour_semaine" required>
              <?php foreach (['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'] as $j): ?>
                <option value="<?= $j ?>"><?= $j ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-6"><input type="time" class="form-control" name="heure_debut" required></div>
          <div class="col-6"><input type="time" class="form-control" name="heure_fin" required></div>
          <div class="col-12"><input type="text" class="form-control" name="lieu" placeholder="Lieu"></div>
          <div class="col-12"><button class="btn btn-sfa-primary">Ajouter</button></div>
        </div>
      </form>
    </div>

    <div class="card border-0 shadow-sm p-4">
      <h6 class="fw-bold mb-3">Planning actuel</h6>
      <table class="table table-sm align-middle">
        <thead><tr><th>Niveau</th><th>Jour</th><th>Horaire</th><th></th></tr></thead>
        <tbody>
          <?php foreach ($planning as $p): ?>
            <tr>
              <td><?= htmlspecialchars($p['niveau']) ?></td>
              <td><?= htmlspecialchars($p['jour_semaine']) ?></td>
              <td><?= substr($p['heure_debut'],0,5) ?>-<?= substr($p['heure_fin'],0,5) ?></td>
              <td><a href="planning-tarifs.php?supprimer_planning=<?= $p['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer ?')"><i class="bi bi-trash"></i></a></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="card border-0 shadow-sm p-4 mb-4">
      <h6 class="fw-bold mb-3">Ajouter un tarif</h6>
      <form method="post">
        <input type="hidden" name="action" value="creer_tarif">
        <div class="row g-2">
          <div class="col-6"><input type="text" class="form-control" name="niveau" placeholder="Niveau" required></div>
          <div class="col-6"><input type="number" class="form-control" name="montant" placeholder="Montant (FCFA)" required></div>
          <div class="col-6">
            <select class="form-select" name="periodicite">
              <option value="mensuel">Mensuel</option>
              <option value="trimestriel">Trimestriel</option>
              <option value="annuel">Annuel</option>
            </select>
          </div>
          <div class="col-6"><input type="text" class="form-control" name="conditions" placeholder="Conditions particulières"></div>
          <div class="col-12"><button class="btn btn-sfa-primary">Ajouter</button></div>
        </div>
      </form>
    </div>

    <div class="card border-0 shadow-sm p-4">
      <h6 class="fw-bold mb-3">Grille tarifaire actuelle</h6>
      <table class="table table-sm align-middle">
        <thead><tr><th>Niveau</th><th>Montant</th><th>Périodicité</th><th></th></tr></thead>
        <tbody>
          <?php foreach ($tarifs as $t): ?>
            <tr>
              <td><?= htmlspecialchars($t['niveau']) ?></td>
              <td><?= number_format($t['montant'],0,',',' ') ?> FCFA</td>
              <td><?= htmlspecialchars($t['periodicite']) ?></td>
              <td><a href="planning-tarifs.php?supprimer_tarif=<?= $t['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer ?')"><i class="bi bi-trash"></i></a></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php require __DIR__ . '/includes/admin-footer.php'; ?>

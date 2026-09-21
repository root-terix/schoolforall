<?php
require_once __DIR__ . '/../config/bootstrap.php';
Auth::exigerConnexion();

$pageActive = 'eleves';
$titrePage = 'Élèves / Inscriptions';

if (isset($_GET['supprimer'])) {
    Eleve::supprimer((int)$_GET['supprimer']);
    header('Location: eleves.php'); exit;
}

$eleves = Eleve::tous();
require __DIR__ . '/includes/admin-header.php';
?>

<div class="card border-0 shadow-sm p-4 mb-4">
  <h6 class="fw-bold mb-1">Importer une liste d'élèves</h6>
  <p class="text-secondary small">Sélectionnez un fichier Excel (.xlsx) ou CSV. Colonnes attendues : nom, prenom, classe, serie, numero_telephone, statut.</p>
  <input type="file" id="fichierImportEleves" class="form-control mb-3" accept=".xlsx,.xls,.csv">
  <div id="apercuImportEleves" class="mb-3"></div>
  <button id="btnValiderImport" class="btn btn-sfa-primary" disabled>Valider l'import</button>
</div>

<div class="card border-0 shadow-sm p-4">
  <h6 class="fw-bold mb-3">Liste des élèves (<?= count($eleves) ?>)</h6>
  <div class="table-responsive">
    <table class="table align-middle">
      <thead><tr><th>Nom</th><th>Prénom</th><th>Classe</th><th>Téléphone</th><th>Statut</th><th>Source</th><th>Date</th><th>Actions</th></tr></thead>
      <tbody>
        <?php foreach ($eleves as $el): ?>
          <tr>
            <td><?= htmlspecialchars($el['nom']) ?></td>
            <td><?= htmlspecialchars($el['prenom']) ?></td>
            <td><?= htmlspecialchars($el['classe']) ?> <?= htmlspecialchars($el['serie'] ?? '') ?></td>
            <td><?= htmlspecialchars($el['numero_telephone'] ?? '') ?></td>
            <td><span class="badge bg-<?= $el['statut']==='nouveau'?'success':'secondary' ?>"><?= htmlspecialchars($el['statut']) ?></span></td>
            <td><span class="badge bg-light text-dark"><?= $el['source_import']==='formulaire' ? 'Formulaire' : 'Import' ?></span></td>
            <td><?= date('d/m/Y', strtotime($el['cree_le'])) ?></td>
            <td><a href="eleves.php?supprimer=<?= $el['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer cet élève ?')"><i class="bi bi-trash"></i></a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require __DIR__ . '/includes/admin-footer.php'; ?>

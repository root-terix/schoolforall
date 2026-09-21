<?php
require_once __DIR__ . '/../config/bootstrap.php';
Auth::exigerConnexion();

$pageActive = 'blog';
$titrePage = 'Newsletter / Blog';
$message = '';

// ---------- Création d'un article ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'creer') {
    $titre = trim($_POST['titre'] ?? '');
    $contenu = trim($_POST['contenu'] ?? '');
    $nomImage = null;

    if (!empty($_FILES['image']['name'])) {
        $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (in_array($extension, ALLOWED_IMAGE_EXTENSIONS)) {
            $nomImage = 'article_' . time() . '.' . $extension;
            move_uploaded_file($_FILES['image']['tmp_name'], UPLOAD_PATH . 'blog/' . $nomImage);
        }
    }

    if ($titre && $contenu) {
        Article::creer($titre, $contenu, $nomImage, $_SESSION['admin_id']);
        $message = 'Publication ajoutée avec succès.';
    }
}

// ---------- Suppression / publication ----------
if (isset($_GET['supprimer'])) {
    Article::supprimer((int)$_GET['supprimer']);
    header('Location: blog.php'); exit;
}
if (isset($_GET['basculer'])) {
    Article::basculerPublication((int)$_GET['basculer']);
    header('Location: blog.php'); exit;
}

$articles = Article::tous(false);
require __DIR__ . '/includes/admin-header.php';
?>

<?php if ($message): ?><div class="alert alert-success"><?= htmlspecialchars($message) ?></div><?php endif; ?>

<div class="card border-0 shadow-sm p-4 mb-4">
  <h6 class="fw-bold mb-3">Nouvelle publication</h6>
  <form method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="creer">
    <div class="row g-3">
      <div class="col-md-8">
        <label class="form-label">Titre</label>
        <input type="text" class="form-control" name="titre" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">Photo (facultatif)</label>
        <input type="file" class="form-control" name="image" accept="image/*">
      </div>
      <div class="col-12">
        <label class="form-label">Contenu</label>
        <textarea class="form-control" name="contenu" rows="4" required placeholder="Rédigez votre publication comme un post Facebook..."></textarea>
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-sfa-primary"><i class="bi bi-send"></i> Publier</button>
      </div>
    </div>
  </form>
</div>

<div class="card border-0 shadow-sm p-4">
  <h6 class="fw-bold mb-3">Publications existantes</h6>
  <div class="table-responsive">
    <table class="table align-middle">
      <thead><tr><th>Titre</th><th>Date</th><th>J'aime</th><th>Commentaires</th><th>Statut</th><th>Actions</th></tr></thead>
      <tbody>
        <?php foreach ($articles as $art): ?>
          <tr>
            <td><?= htmlspecialchars($art['titre']) ?></td>
            <td><?= date('d/m/Y', strtotime($art['cree_le'])) ?></td>
            <td><?= (int)$art['nombre_likes'] ?></td>
            <td><?= (int)$art['nombre_commentaires'] ?></td>
            <td><span class="badge <?= $art['est_publie'] ? 'bg-success' : 'bg-secondary' ?>"><?= $art['est_publie'] ? 'Publié' : 'Brouillon' ?></span></td>
            <td class="d-flex gap-2">
              <a href="blog.php?basculer=<?= $art['id'] ?>" class="btn btn-sm btn-outline-secondary" title="Publier / dépublier"><i class="bi bi-eye"></i></a>
              <a href="blog.php?supprimer=<?= $art['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer cette publication ?')"><i class="bi bi-trash"></i></a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require __DIR__ . '/includes/admin-footer.php'; ?>

<?php
require_once __DIR__ . '/../config/bootstrap.php';
$pageActive = 'blog';
Auth::demarrerSession();
if (!isset($_SESSION['visiteur_id'])) {
    $_SESSION['visiteur_id'] = bin2hex(random_bytes(8));
}
$visiteurId = $_SESSION['visiteur_id'];

$id = (int)($_GET['id'] ?? 0);
$article = Article::trouver($id);
$commentaires = $article ? Article::commentaires($id) : [];
$aAime = $article ? Article::aAimeParVisiteur($id, $visiteurId) : false;
$nombreLikes = $article ? Article::compterLikes($id) : 0;

function tempsEcoule($date) {
    $diff = time() - strtotime($date);
    if ($diff < 60) return 'à l\'instant';
    if ($diff < 3600) return floor($diff / 60) . ' min';
    if ($diff < 86400) return floor($diff / 3600) . ' h';
    if ($diff < 604800) return floor($diff / 86400) . ' j';
    return date('d/m/Y', strtotime($date));
}

require __DIR__ . '/includes/header.php';
?>
<section class="container py-5" style="max-width:720px;">
  <?php if (!$article): ?>
    <p class="text-secondary">Publication introuvable. <a href="blog.php">Retour au blog</a></p>
  <?php else: ?>
    <a href="blog.php" class="small d-inline-block mb-3"><i class="bi bi-arrow-left"></i> Retour au blog</a>

    <div class="sfa-fb-post" data-aos="fade-up">
      <div class="sfa-fb-header">
        <div class="sfa-fb-avatar">SF</div>
        <div class="sfa-fb-meta">
          <div class="fb-name">SCHOOL FOR ALL <i class="bi bi-patch-check-fill" style="color:var(--sfa-pink); font-size:.75rem;"></i></div>
          <div class="fb-time"><?= tempsEcoule($article['cree_le']) ?> <i class="bi bi-globe-americas"></i></div>
        </div>
      </div>
      <div class="sfa-fb-body"><?= nl2br(htmlspecialchars($article['contenu'])) ?></div>

      <div class="sfa-fb-thumb-wrap" style="aspect-ratio:auto; max-height:420px;">
        <?php if ($article['image']): ?>
          <img src="<?= UPLOAD_URL . 'blog/' . htmlspecialchars($article['image']) ?>" alt="">
        <?php else: ?>
          <i class="bi bi-mortarboard-fill sfa-fb-thumb-fallback" style="font-size:3.5rem;"></i>
        <?php endif; ?>
      </div>

      <div class="sfa-fb-stats">
        <span><i class="bi bi-hand-thumbs-up-fill" style="color:var(--sfa-pink)"></i> <span id="nombreLikesTotal"><?= $nombreLikes ?></span></span>
        <span><?= count($commentaires) ?> commentaires</span>
      </div>

      <div class="sfa-fb-actions" id="partage">
        <button class="sfa-like-btn <?= $aAime ? 'active' : '' ?>" data-article-id="<?= $article['id'] ?>">
          <i class="bi bi-hand-thumbs-up<?= $aAime ? '-fill' : '' ?>"></i> J'aime
        </button>
        <button onclick="document.getElementById('champCommentaire').focus()">
          <i class="bi bi-chat-dots"></i> Commenter
        </button>
        <button onclick="navigator.clipboard.writeText(window.location.href); this.innerHTML='<i class=\'bi bi-check2\'></i> Lien copié';">
          <i class="bi bi-share"></i> Partager
        </button>
      </div>

      <div class="p-3 border-top">
        <h6 class="fw-bold small mb-3">Commentaires</h6>
        <div id="listeCommentaires">
          <?php foreach ($commentaires as $c): ?>
            <div class="d-flex gap-2 mb-3">
              <div class="sfa-fb-avatar" style="width:34px;height:34px;font-size:.7rem;"><?= strtoupper(mb_substr($c['nom_auteur'],0,1)) ?></div>
              <div class="bg-light rounded-4 px-3 py-2 flex-grow-1">
                <p class="fw-semibold mb-0 small"><?= htmlspecialchars($c['nom_auteur']) ?></p>
                <p class="mb-0 small"><?= nl2br(htmlspecialchars($c['contenu'])) ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <form id="formCommentaire" class="d-flex gap-2 mt-3">
          <input type="hidden" name="article_id" value="<?= $article['id'] ?>">
          <input type="text" class="form-control form-control-sm" name="nom_auteur" placeholder="Votre nom" required style="max-width:140px;">
          <input type="text" id="champCommentaire" class="form-control form-control-sm rounded-pill" name="contenu" placeholder="Écrire un commentaire…" required>
          <button type="submit" class="btn btn-sfa-primary btn-sm rounded-circle" style="width:36px;height:36px;"><i class="bi bi-send"></i></button>
        </form>
      </div>
    </div>
  <?php endif; ?>
</section>
<script src="assets/js/blog.js"></script>
<?php require __DIR__ . '/includes/footer.php'; ?>

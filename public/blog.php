<?php
require_once __DIR__ . '/../config/bootstrap.php';
$pageActive = 'blog';
Auth::demarrerSession();
if (!isset($_SESSION['visiteur_id'])) {
    $_SESSION['visiteur_id'] = bin2hex(random_bytes(8));
}
$visiteurId = $_SESSION['visiteur_id'];
$articles = Article::tous(true);
require __DIR__ . '/includes/header.php';

function tempsEcoule($date) {
    $diff = time() - strtotime($date);
    if ($diff < 60) return 'à l\'instant';
    if ($diff < 3600) return floor($diff / 60) . ' min';
    if ($diff < 86400) return floor($diff / 3600) . ' h';
    if ($diff < 604800) return floor($diff / 86400) . ' j';
    return date('d/m/Y', strtotime($date));
}
?>
<section class="container py-5" style="max-width:720px;">
  <div class="text-center mb-4" data-aos="fade-up">
    <span class="badge-pill">ACTUALITÉS</span>
    <h1 class="fw-bold mt-3">Blog & Newsletter</h1>
    <p class="text-secondary">Toute l'actualité de SCHOOL FOR ALL, comme sur votre fil d'actualité préféré.</p>
  </div>

  <?php if (empty($articles)): ?>
    <p class="text-secondary text-center">Aucune publication pour le moment.</p>
  <?php endif; ?>

  <?php foreach ($articles as $i => $art):
    $aAime = Article::aAimeParVisiteur($art['id'], $visiteurId);
  ?>
    <div class="sfa-fb-post" data-aos="fade-up" data-aos-delay="<?= min($i * 60, 300) ?>">
      <div class="sfa-fb-header">
        <div class="sfa-fb-avatar">SF</div>
        <div class="sfa-fb-meta">
          <div class="fb-name">SCHOOL FOR ALL <i class="bi bi-patch-check-fill" style="color:var(--sfa-pink); font-size:.75rem;"></i></div>
          <div class="fb-time"><?= tempsEcoule($art['cree_le']) ?> <i class="bi bi-globe-americas"></i></div>
        </div>
      </div>
      <div class="sfa-fb-body"><?= nl2br(htmlspecialchars(mb_strimwidth($art['contenu'], 0, 260, '…'))) ?></div>

      <div class="sfa-fb-thumb-wrap">
        <?php if ($art['image']): ?>
          <img src="<?= UPLOAD_URL . 'blog/' . htmlspecialchars($art['image']) ?>" alt="<?= htmlspecialchars($art['titre']) ?>">
        <?php else: ?>
          <i class="bi bi-mortarboard-fill sfa-fb-thumb-fallback"></i>
        <?php endif; ?>
      </div>

      <div class="sfa-fb-stats">
        <span><i class="bi bi-hand-thumbs-up-fill" style="color:var(--sfa-pink)"></i> <?= (int)$art['nombre_likes'] ?></span>
        <span><?= (int)$art['nombre_commentaires'] ?> commentaires</span>
      </div>

      <div class="sfa-fb-actions">
        <button class="sfa-like-btn <?= $aAime ? 'active' : '' ?>" data-article-id="<?= $art['id'] ?>">
          <i class="bi bi-hand-thumbs-up<?= $aAime ? '-fill' : '' ?>"></i> J'aime
        </button>
        <a href="blog-detail.php?id=<?= $art['id'] ?>"><i class="bi bi-chat-dots"></i> Commenter</a>
        <a href="blog-detail.php?id=<?= $art['id'] ?>#partage"><i class="bi bi-share"></i> Partager</a>
      </div>
    </div>
  <?php endforeach; ?>
</section>
<script src="assets/js/blog.js"></script>
<?php require __DIR__ . '/includes/footer.php'; ?>

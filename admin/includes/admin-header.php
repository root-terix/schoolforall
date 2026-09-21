<?php
/**
 * En-tête et menu latéral communs à toutes les pages du tableau de bord.
 * Attend une variable $pageActive définie avant l'inclusion.
 */
if (!isset($pageActive)) { $pageActive = ''; }
function adminNavActive($page, $pageActive) {
    return $page === $pageActive ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tableau de bord — <?= SITE_NAME ?></title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">
<link rel="stylesheet" href="../public/assets/css/styles.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
</head>
<body class="sfa-admin-body">
<div class="d-flex">
  <div class="sfa-admin-sidebar p-3" style="width:260px; flex-shrink:0;">
    <h5 class="fw-bold text-white mb-4 d-flex align-items-center gap-2">
      <img src="../public/assets/img/logo.jpg" alt="Logo" class="sfa-logo-img" style="width:34px;height:34px;">
      SCHOOL <span style="color:var(--sfa-pink)">FOR ALL</span>
    </h5>
    <nav class="nav flex-column gap-1">
      <a href="dashboard.php" class="<?= adminNavActive('dashboard', $pageActive) ?>"><i class="bi bi-speedometer2 me-2"></i> Tableau de bord</a>
      <a href="blog.php" class="<?= adminNavActive('blog', $pageActive) ?>"><i class="bi bi-newspaper me-2"></i> Newsletter / Blog</a>
      <a href="epreuves.php" class="<?= adminNavActive('epreuves', $pageActive) ?>"><i class="bi bi-file-earmark-text me-2"></i> Épreuves & corrigés</a>
      <a href="eleves.php" class="<?= adminNavActive('eleves', $pageActive) ?>"><i class="bi bi-people me-2"></i> Élèves / Inscriptions</a>
      <a href="temoignages.php" class="<?= adminNavActive('temoignages', $pageActive) ?>"><i class="bi bi-chat-quote me-2"></i> Témoignages</a>
      <a href="resultats.php" class="<?= adminNavActive('resultats', $pageActive) ?>"><i class="bi bi-bar-chart me-2"></i> Résultats</a>
      <a href="planning-tarifs.php" class="<?= adminNavActive('planning', $pageActive) ?>"><i class="bi bi-calendar3 me-2"></i> Planning & Tarifs</a>
      <a href="evenements.php" class="<?= adminNavActive('evenements', $pageActive) ?>"><i class="bi bi-calendar-event me-2"></i> Événements</a>
      <a href="enseignants.php" class="<?= adminNavActive('enseignants', $pageActive) ?>"><i class="bi bi-person-badge me-2"></i> Équipe pédagogique</a>
      <hr class="border-secondary">
      <a href="../public/index.php" target="_blank"><i class="bi bi-box-arrow-up-right me-2"></i> Voir le site</a>
      <a href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> Déconnexion</a>
    </nav>
  </div>
  <div class="flex-grow-1">
    <div class="bg-white border-bottom px-4 py-3 d-flex justify-content-between align-items-center">
      <h5 class="mb-0 fw-bold text-capitalize"><?= htmlspecialchars($titrePage ?? 'Tableau de bord') ?></h5>
      <span class="text-secondary small"><i class="bi bi-person-circle"></i> <?= htmlspecialchars(Auth::nomAdmin()) ?></span>
    </div>
    <div class="p-4">

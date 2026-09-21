<?php
/**
 * En-tête commun à toutes les pages publiques.
 * Attend éventuellement une variable $pageActive définie avant l'inclusion.
 */
if (!isset($pageActive)) { $pageActive = ''; }
function navActive($page, $pageActive) {
    return $page === $pageActive ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= SITE_NAME ?> — Votre réussite commence ici</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">
<link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white sfa-navbar sticky-top py-2">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-dark" href="index.php">
      <img src="assets/img/logo.jpg" alt="SCHOOL FOR ALL" class="sfa-logo-img">
      <span class="d-none d-sm-inline">SCHOOL <span style="color:var(--sfa-pink)">FOR ALL</span></span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sfaNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="sfaNav">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item"><a class="nav-link <?= navActive('accueil', $pageActive) ?>" href="index.php">Accueil</a></li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?= navActive('cours', $pageActive) ?>" href="cours.php" role="button" data-bs-toggle="dropdown">Nos cours</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="cours.php">Tous les cours</a></li>
            <li><a class="dropdown-item" href="cours.php#niveaux">Cours par niveau</a></li>
            <li><a class="dropdown-item" href="cours.php#stages">Stages & préparation aux examens</a></li>
          </ul>
        </li>

        <li class="nav-item"><a class="nav-link <?= navActive('methode', $pageActive) ?>" href="methode.php">Méthode</a></li>
        <li class="nav-item"><a class="nav-link <?= navActive('equipe', $pageActive) ?>" href="equipe.php">Équipe</a></li>
        <li class="nav-item"><a class="nav-link <?= navActive('resultats', $pageActive) ?>" href="resultats.php">Résultats</a></li>
        <li class="nav-item"><a class="nav-link <?= navActive('evenements', $pageActive) ?>" href="evenements.php">Événements</a></li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?= navActive('ressources', $pageActive) ?>" href="#" role="button" data-bs-toggle="dropdown">Ressources</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="epreuves.php">Épreuves & corrigés</a></li>
            <li><a class="dropdown-item" href="blog.php">Blog & Newsletter</a></li>
            <li><a class="dropdown-item" href="tarifs-planning.php">Tarifs & Planning</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?= navActive('orientation', $pageActive) ?>" href="orientation.php" role="button" data-bs-toggle="dropdown">Orientation</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="orientation.php#concours">Concours</a></li>
            <li><a class="dropdown-item" href="orientation.php#ecoles">Écoles & Universités</a></li>
            <li><a class="dropdown-item" href="orientation.php#bourses">Bourses d'étude</a></li>
          </ul>
        </li>

        <li class="nav-item"><a class="nav-link <?= navActive('contact', $pageActive) ?>" href="contact.php">Contact</a></li>
      </ul>
      <a href="inscription.php" class="btn btn-sfa-primary">
        <i class="bi bi-pencil-square"></i> S'inscrire
      </a>
    </div>
  </div>
</nav>

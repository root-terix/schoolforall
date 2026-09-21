<?php
require_once __DIR__ . '/../config/bootstrap.php';
Auth::demarrerSession();

$erreur = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $motDePasse = $_POST['mot_de_passe'] ?? '';
    $admin = Administrateur::trouverParEmail($email);

    if ($admin && Administrateur::verifierMotDePasse($motDePasse, $admin['mot_de_passe'])) {
        Auth::connecter($admin);
        header('Location: dashboard.php');
        exit;
    }
    $erreur = 'Identifiants incorrects. Veuillez réessayer.';
}

if (Auth::estConnecte()) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Connexion administrateur — <?= SITE_NAME ?></title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../public/assets/css/styles.css">
</head>
<body class="d-flex align-items-center" style="min-height:100vh; background:var(--sfa-pink-light)">
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card border-0 shadow-sm p-4">
        <div class="text-center mb-2">
          <img src="../public/assets/img/logo.jpg" alt="Logo" style="width:64px;height:64px;border-radius:50%;">
        </div>
        <h4 class="fw-bold text-center mb-1">SCHOOL <span style="color:var(--sfa-pink)">FOR ALL</span></h4>
        <p class="text-center text-secondary mb-4">Tableau de bord administrateur</p>
        <?php if ($erreur): ?>
          <div class="alert alert-danger small"><?= htmlspecialchars($erreur) ?></div>
        <?php endif; ?>
        <form method="post">
          <div class="mb-3">
            <label class="form-label fw-semibold">E-mail</label>
            <input type="email" class="form-control" name="email" required autofocus>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Mot de passe</label>
            <input type="password" class="form-control" name="mot_de_passe" required>
          </div>
          <button type="submit" class="btn btn-sfa-primary w-100">Se connecter</button>
        </form>
        <p class="text-secondary small text-center mt-3 mb-0">
          Accès réservé à l'équipe SCHOOL FOR ALL.
        </p>
      </div>
    </div>
  </div>
</div>
</body>
</html>

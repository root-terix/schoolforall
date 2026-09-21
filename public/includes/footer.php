<footer class="sfa-footer mt-5">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-3 col-sm-6">
        <div class="d-flex align-items-center gap-2 mb-3">
          <img src="assets/img/logo.jpg" alt="SCHOOL FOR ALL" class="sfa-footer-logo">
          <span class="fw-bold text-white">SCHOOL FOR ALL</span>
        </div>
        <p class="small">SCHOOL FOR ALL est un groupe d'études engagé pour la réussite scolaire de chaque élève, de la 6ème à la Terminale.</p>
        <div class="d-flex gap-2">
          <a href="#" class="sfa-social-circle sfa-social-facebook"><i class="bi bi-facebook"></i></a>
          <a href="https://wa.me/<?= WHATSAPP_NUMBER ?>" class="sfa-social-circle sfa-social-whatsapp"><i class="bi bi-whatsapp"></i></a>
          <a href="#" class="sfa-social-circle sfa-social-instagram"><i class="bi bi-instagram"></i></a>
          <a href="#" class="sfa-social-circle sfa-social-youtube"><i class="bi bi-youtube"></i></a>
        </div>
      </div>
      <div class="col-lg-2 col-sm-6">
        <h6>Navigation</h6>
        <ul class="list-unstyled small">
          <li><a href="index.php">Accueil</a></li>
          <li><a href="cours.php">Nos cours</a></li>
          <li><a href="methode.php">Notre méthode</a></li>
          <li><a href="equipe.php">Notre équipe</a></li>
          <li><a href="resultats.php">Nos résultats</a></li>
          <li><a href="evenements.php">Événements</a></li>
          <li><a href="contact.php">Contact</a></li>
        </ul>
      </div>
      <div class="col-lg-2 col-sm-6">
        <h6>Ressources</h6>
        <ul class="list-unstyled small">
          <li><a href="epreuves.php?type=BEPC">Sujets BEPC</a></li>
          <li><a href="epreuves.php?type=Probatoire">Sujets Probatoire</a></li>
          <li><a href="epreuves.php?type=Baccalaureat">Sujets Baccalauréat</a></li>
          <li><a href="epreuves.php?type=ETNS">Sujets ETNS</a></li>
          <li><a href="epreuves.php">Corrigés des épreuves</a></li>
        </ul>
      </div>
      <div class="col-lg-2 col-sm-6">
        <h6>Orientation</h6>
        <ul class="list-unstyled small">
          <li><a href="orientation.php#concours">Concours</a></li>
          <li><a href="orientation.php#ecoles">Écoles & Universités</a></li>
          <li><a href="orientation.php#emplois">Emplois & Opportunités</a></li>
          <li><a href="orientation.php#stages">Stages</a></li>
        </ul>
      </div>
      <div class="col-lg-3 col-sm-6">
        <h6>Contactez-nous</h6>
        <ul class="list-unstyled small">
          <li><i class="bi bi-telephone-fill me-2"></i>+237 6 99 09 02 31</li>
          <li><i class="bi bi-whatsapp me-2"></i>+1 289 713 7471</li>
          <li><i class="bi bi-geo-alt-fill me-2"></i>Quartier Angale, Ebolowa, Cameroun</li>
          <li><i class="bi bi-clock-fill me-2"></i>Lun - Sam : 07h00 - 18h00</li>
          <li><i class="bi bi-envelope-fill me-2"></i>contact@schoolforall.cm</li>
        </ul>
      </div>
    </div>
  </div>
  <div class="sfa-footer-bottom">
    <div class="container d-flex flex-wrap justify-content-center justify-content-md-between align-items-center gap-2">
      <span>&copy; <?= date('Y') ?> SCHOOL FOR ALL - Tous droits réservés.</span>
      <a href="politique-confidentialite.php" class="small text-white">Politique de confidentialité & cookies</a>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>AOS.init({ duration: 800, once: true, offset: 60, easing: 'ease-out-cubic' });</script>
<script src="assets/js/main.js"></script>
<script src="assets/js/counters.js"></script>
</body>
</html>

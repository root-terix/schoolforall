<?php
require_once __DIR__ . '/../config/bootstrap.php';
$pageActive = 'contact';
require __DIR__ . '/includes/header.php';
?>
<section class="container py-5">
  <h1 class="fw-bold mb-3">Contact</h1>
  <p class="text-secondary fs-5 mb-5">Une question ? Contactez-nous directement, nous vous répondrons rapidement.</p>

  <div class="row g-4">
    <div class="col-lg-5">
      <div class="sfa-card h-100">
        <ul class="list-unstyled">
          <li class="mb-3"><i class="bi bi-geo-alt-fill me-2" style="color:var(--sfa-pink)"></i> Quartier Centre, Ebolowa, Cameroun</li>
          <li class="mb-3"><i class="bi bi-telephone-fill me-2" style="color:var(--sfa-pink)"></i> +237 6 12 34 56 78</li>
          <li class="mb-3"><i class="bi bi-whatsapp me-2" style="color:var(--sfa-pink)"></i> +237 6 12 34 56 78</li>
          <li class="mb-3"><i class="bi bi-clock-fill me-2" style="color:var(--sfa-pink)"></i> Lundi - Samedi : 07h00 - 18h00</li>
          <li class="mb-3"><i class="bi bi-envelope-fill me-2" style="color:var(--sfa-pink)"></i> contact@schoolforall.cm</li>
          <li><i class="bi bi-facebook me-2" style="color:var(--sfa-pink)"></i> facebook.com/schoolforall</li>
        </ul>
        <a href="https://wa.me/237612345678" target="_blank" class="btn btn-sfa-primary mt-2"><i class="bi bi-whatsapp"></i> Discuter sur WhatsApp</a>
      </div>
    </div>
    <div class="col-lg-7">
      <div class="ratio ratio-4x3 rounded-4 overflow-hidden">
        <iframe src="https://www.google.com/maps?q=Ebolowa,Cameroun&output=embed" style="border:0" loading="lazy"></iframe>
      </div>
    </div>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>

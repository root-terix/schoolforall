<?php
require_once __DIR__ . '/../config/bootstrap.php';
$pageActive = 'inscription';
require __DIR__ . '/includes/header.php';
?>
<section class="container py-5">
  <h1 class="fw-bold mb-2">Fiche d'inscription</h1>
  <p class="text-secondary fs-5 mb-4">« L'orientation vers la réussite appartient à tous ». Remplissez ce formulaire, votre fiche sera envoyée automatiquement sur WhatsApp.</p>

  <div id="messageConfirmation" class="alert alert-success d-none"></div>
  <div id="messageErreur" class="alert alert-danger d-none"></div>

  <form id="formInscription" enctype="multipart/form-data" novalidate data-aos="fade-up">
    <div class="row g-3">
      <div class="col-md-3">
        <label class="form-label fw-semibold">Photo (4x4)</label>
        <input type="file" class="form-control" name="photo" accept="image/*">
      </div>
      <div class="col-md-4">
        <label class="form-label fw-semibold">Nom *</label>
        <input type="text" class="form-control" name="nom" required>
      </div>
      <div class="col-md-5">
        <label class="form-label fw-semibold">Prénom *</label>
        <input type="text" class="form-control" name="prenom" required>
      </div>

      <div class="col-md-4">
        <label class="form-label fw-semibold">Date de naissance</label>
        <input type="date" class="form-control" name="date_naissance">
      </div>
      <div class="col-md-4">
        <label class="form-label fw-semibold">Lieu de naissance</label>
        <input type="text" class="form-control" name="lieu_naissance">
      </div>
      <div class="col-md-4">
        <label class="form-label fw-semibold">Nationalité</label>
        <input type="text" class="form-control" name="nationalite">
      </div>

      <div class="col-md-6">
        <label class="form-label fw-semibold">Numéro de téléphone *</label>
        <input type="tel" class="form-control" name="numero_telephone" required placeholder="6XX XXX XXX">
      </div>
      <div class="col-md-6">
        <label class="form-label fw-semibold">Établissement d'origine</label>
        <input type="text" class="form-control" name="etablissement">
      </div>

      <div class="col-md-3">
        <label class="form-label fw-semibold">Classe *</label>
        <select class="form-select" name="classe" required>
          <option value="">Choisir…</option>
          <?php foreach (['6ème','5ème','4ème','3ème','2nde','1ère','Terminale'] as $c): ?>
            <option value="<?= $c ?>"><?= $c ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label fw-semibold">Série</label>
        <input type="text" class="form-control" name="serie" placeholder="A, C, D, TI…">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-semibold">Année scolaire</label>
        <input type="text" class="form-control" name="annee_scolaire" placeholder="2026-2027">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-semibold">Statut *</label>
        <select class="form-select" name="statut" required>
          <option value="nouveau">Nouveau</option>
          <option value="ancien">Ancien</option>
        </select>
      </div>

      <div class="col-md-8">
        <label class="form-label fw-semibold">Adresse</label>
        <input type="text" class="form-control" name="adresse">
      </div>
      <div class="col-md-4">
        <label class="form-label fw-semibold">Date de début des cours</label>
        <input type="date" class="form-control" name="date_debut_cours">
      </div>

      <div class="col-12"><hr></div>
      <div class="col-md-4">
        <label class="form-label fw-semibold">Personne à contacter en urgence</label>
        <input type="text" class="form-control" name="contact_urgence_nom">
      </div>
      <div class="col-md-4">
        <label class="form-label fw-semibold">Numéro</label>
        <input type="tel" class="form-control" name="contact_urgence_numero">
      </div>
      <div class="col-md-4">
        <label class="form-label fw-semibold">Adresse</label>
        <input type="text" class="form-control" name="contact_urgence_adresse">
      </div>

      <div class="col-12"><hr></div>
      <div class="col-md-6">
        <label class="form-label fw-semibold">Par quel moyen avez-vous découvert SCHOOL FOR ALL ?</label>
        <input type="text" class="form-control" name="moyen_decouverte">
      </div>
      <div class="col-md-6">
        <label class="form-label fw-semibold d-block">Avez-vous des difficultés scolaires ?</label>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="a_difficulte_scolaire" value="1" id="difOui">
          <label class="form-check-label" for="difOui">Oui</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="a_difficulte_scolaire" value="0" id="difNon" checked>
          <label class="form-check-label" for="difNon">Non</label>
        </div>
      </div>
      <div class="col-12">
        <label class="form-label fw-semibold">Si oui, précisez</label>
        <textarea class="form-control" name="details_difficulte" rows="2"></textarea>
      </div>
      <div class="col-12">
        <label class="form-label fw-semibold">Parlez-nous de votre projet de carrière</label>
        <textarea class="form-control" name="projet_carriere" rows="3"></textarea>
      </div>

      <div class="col-12">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="reglement_accepte" value="1" id="reglement" required>
          <label class="form-check-label small" for="reglement">
            J'ai lu et j'accepte toutes les conditions du règlement intérieur de SCHOOL FOR ALL. *
          </label>
        </div>
      </div>

      <div class="col-12 mt-3">
        <button type="submit" class="btn btn-sfa-primary btn-lg" id="btnSubmitInscription">
          <i class="bi bi-whatsapp"></i> S'inscrire
        </button>
      </div>
    </div>
  </form>
</section>

<!-- Modale de confirmation avec fiche imprimable / PDF / WhatsApp -->
<div class="modal fade" id="modaleFiche" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header no-print">
        <h5 class="modal-title fw-bold"><i class="bi bi-check-circle-fill text-success"></i> Inscription enregistrée</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-0">
        <!-- Fiche imprimable / exportable en PDF — reproduction exacte du modèle officiel -->
        <div id="ficheImpression" class="fiche-officielle" style="width:100%;">
          <div id="contenuFiche"></div>
        </div>
      </div>
      <div class="modal-footer no-print flex-wrap">
        <button type="button" class="btn btn-sfa-outline" id="btnImprimerFiche"><i class="bi bi-printer"></i> Imprimer</button>
        <button type="button" class="btn btn-sfa-outline" id="btnTelechargerPdf"><i class="bi bi-file-earmark-pdf"></i> Télécharger en PDF</button>
        <button type="button" class="btn btn-sfa-primary" id="btnEnvoyerWhatsapp"><i class="bi bi-whatsapp"></i> Envoyer sur WhatsApp</button>
      </div>
      <p class="small text-secondary text-center px-3 pb-3 mb-0 no-print">
        Astuce : téléchargez d'abord le PDF, puis joignez-le manuellement dans la conversation WhatsApp qui s'ouvre
        (WhatsApp Web ne permet pas de joindre un fichier automatiquement depuis un site).
      </p>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
<script src="assets/js/inscription.js"></script>
<?php require __DIR__ . '/includes/footer.php'; ?>

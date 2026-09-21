/**
 * SCHOOL FOR ALL — inscription.js
 * Validation et envoi du formulaire d'inscription en ligne, puis génération
 * d'une reproduction exacte de la fiche d'inscription officielle
 * (imprimable / exportable en PDF / envoyable sur WhatsApp).
 */
document.addEventListener('DOMContentLoaded', function () {
  const formulaireInscription = document.getElementById('formInscription');
  if (!formulaireInscription) return;

  const messageConfirmation = document.getElementById('messageConfirmation');
  const messageErreur = document.getElementById('messageErreur');
  const boutonSubmit = document.getElementById('btnSubmitInscription');
  const contenuFiche = document.getElementById('contenuFiche');
  let numeroWhatsappActuel = '';
  let recapitulatifActuel = '';

  // Case à cocher : "■" si cochée, "☐" sinon (rendu identique au document papier)
  function caseACocher(estCochee) {
    return estCochee ? '<span class="box">✕</span>' : '<span class="box"></span>';
  }

  function pointille(valeur, largeurEm) {
    const v = valeur ? valeur : '';
    return `<span class="valeur" style="display:inline-block; min-width:${largeurEm}em;">${v}</span>`;
  }

  /**
   * Reconstruit fidèlement la fiche d'inscription officielle SCHOOL FOR ALL
   * (en-tête bilingue Cameroun, photo 4x4, champs, règlement en 20 points, signature).
   */
  function construireFiche(f) {
    const photoHtml = f.photo
      ? `<img src="${f.photo}" alt="Photo">`
      : `4X4`;

    const html = `
      <div class="fiche-entete">
        <div style="flex:1;">
          REPUBLIQUE DU CAMEROUN<br>
          Paix - Travail - Patrie<br>
          <span class="devise">*********</span><br>
          MINISTERE DE L'ENSEIGNEMENT<br>SECONDAIRE<br>
          <span class="devise">*********</span><br>
          <span style="color:#0d6efd;">SCHOOL FOR ALL</span>
        </div>
        <img src="assets/img/logo.jpg" class="fiche-logo" alt="Logo">
        <div style="flex:1;">
          REPUBLIC OF CAMEROON<br>
          Peace - Work - Fatherland<br>
          <span class="devise">*********</span><br>
          MINISTRY OF HIGHER EDUCATION<br><br>
          <span class="devise">*********</span><br>
          <span style="color:#0d6efd;">SCHOOL FOR ALL</span>
        </div>
      </div>

      <div class="fiche-titre">
        <h2>FICHE D'INSCRIPTION</h2>
        <p>(L'orientation vers la réussite appartient à nous)</p>
      </div>

      <div style="margin-top:14px; overflow:auto;">
        <div class="fiche-photo-box">${photoHtml}</div>

        <div class="fiche-champ"><strong>NOM</strong> : ${pointille(f.nom, 22)}</div>
        <div class="fiche-champ"><strong>PRENOM</strong> : ${pointille(f.prenom, 22)}</div>
        <div class="fiche-champ">
          <strong>DATE DE NAISSANCE</strong> : ${pointille(f.date_naissance, 10)}
          &nbsp;&nbsp;<strong>LIEU</strong> : ${pointille(f.lieu_naissance, 12)}
        </div>
        <div class="fiche-champ">
          <strong>NATIONALITE</strong> : ${pointille(f.nationalite, 14)}
          &nbsp;&nbsp;<strong>NUMERO</strong> : ${pointille(f.numero_telephone, 14)}
        </div>
      </div>

      <div class="fiche-champ" style="clear:both;"><strong>ETABLISSEMENT</strong> : ${pointille(f.etablissement, 40)}</div>

      <div class="fiche-champ">
        <strong>CLASSE</strong> : ${pointille(f.classe, 8)}
        &nbsp;<strong>SERIE</strong> : ${pointille(f.serie, 6)}
        &nbsp;<strong>ANNEE SCOLAIRE</strong> : ${pointille(f.annee_scolaire, 10)}
        &nbsp;&nbsp;<strong>STATUT</strong> :
        ${caseACocher(f.statut === 'nouveau')} Nouveau
        &nbsp;${caseACocher(f.statut === 'ancien')} Ancien
      </div>

      <div class="fiche-champ"><strong>ADRESSE</strong> : ${pointille(f.adresse, 45)}</div>
      <div class="fiche-champ"><strong>DATE DU DEBUT DES COURS A SCHOOL FOR ALL</strong> : ${pointille(f.date_debut_cours, 14)}</div>
      <div class="fiche-champ"><strong>PERSONNE A CONTACTER EN CAS URGENCE</strong> : ${pointille(f.contact_urgence_nom, 30)}</div>
      <div class="fiche-champ">
        <strong>NUMERO</strong> : ${pointille(f.contact_urgence_numero, 16)}
        &nbsp;&nbsp;<strong>ADRESSE</strong> : ${pointille(f.contact_urgence_adresse, 20)}
      </div>
      <div class="fiche-champ"><strong>PAR QUEL MOYEN AVEZ-VOUS DECOUVERT SCHOOL FOR ALL ?</strong> : ${pointille(f.moyen_decouverte, 30)}</div>
      <div class="fiche-champ">
        <strong>AVEZ-VOUS DES DIFICULTE SCOLAIRE ?</strong>
        ${caseACocher(!f.a_difficulte_scolaire)} NON
        &nbsp;${caseACocher(!!f.a_difficulte_scolaire)} OUI <em>(si oui indiquez nous)</em>
      </div>
      <div class="fiche-champ" style="border-bottom:1px dotted #444; min-height:16px;">${f.a_difficulte_scolaire ? (f.details_difficulte || '') : ''}</div>
      <div class="fiche-champ" style="border-bottom:1px dotted #444; min-height:16px;">&nbsp;</div>

      <div class="fiche-champ" style="margin-top:10px;"><strong>PARLEZ NOUS DE VOTRE PROJET DE CARRIERE</strong></div>
      <div class="fiche-champ" style="border-bottom:1px dotted #444; min-height:16px;">${f.projet_carriere || ''}</div>
      <div class="fiche-champ" style="border-bottom:1px dotted #444; min-height:16px;">&nbsp;</div>

      <div class="fiche-reglement">
        <h6>REGLEMENT ET CONDITIONNEMENT</h6>
        <ol>
          <li><strong>Nul n'est censé ignorer le règlement intérieur.</strong></li>
          <li><strong>ASSIDUITE ET PONCTUALITE</strong> : Chaque élève doit respecter les horaires des cours. Tout retard doit être justifié.</li>
          <li><strong>Présence obligatoire</strong> : Les absences doivent être signalées au coordinateur ou à un enseignant au plus tard le jour même.</li>
          <li><strong>Respect mutuel</strong> : les élèves, enseignants et encadreurs doivent se traiter avec respect et courtoisie.</li>
          <li><strong>Matériel scolaire</strong> : Chaque élève doit venir avec son cahier, livres, stylos et tout autre matériel requis.</li>
          <li><strong>Discipline en classe</strong> : Aucun bavardage, perturbation ou comportement déplacé ne sera toléré pendant les cours.</li>
          <li><strong>Tenue correcte</strong> : une tenue décente est exigée (éviter casquettes, écouteurs, etc. pendant les cours).</li>
          <li><strong>Participation active</strong> : Les élèves doivent s'impliquer, poser des questions et participer aux exercices proposés.</li>
          <li><strong>Propreté et ordre</strong> : Les salles de cours doivent être maintenues propres, aucun déchet ne doit être laissé sur place.</li>
          <li><strong>Respect du matériel</strong> : Le matériel pédagogique (tableau, craie, chaises, projecteur, etc.) doit être utilisé avec soin.</li>
          <li><strong>Interdiction de la tricherie</strong> : Toute tentative de fraude lors des évaluations entraîne des sanctions.</li>
          <li><strong>Langage approprié</strong> : Aucun propos vulgaire, discriminant ou insultant n'est accepté.</li>
          <li><strong>Travail en équipe</strong> : L'entraide entre élèves est encouragée, mais chacun reste responsable de son travail.</li>
          <li><strong>Confidentialité</strong> : Les informations personnelles ou scolaires d'un élève ne doivent pas être divulguées en dehors du groupe.</li>
          <li><strong>Respect des encadreurs</strong> : Les décisions et orientations des enseignants doivent être suivies avec discipline.</li>
          <li><strong>Engagement à la réussite</strong> : Chaque élève s'engage à travailler sérieusement, respecter les consignes des enseignants et participer aux évaluations mensuelles.</li>
          <li><strong>Sécurité</strong> : Tout comportement mettant en danger soi-même ou autrui est interdit.</li>
          <li><strong>Interdiction des substances nuisibles</strong> : Il est strictement interdit de consommer alcool, tabac ou drogues dans le cadre de SCHOOL FOR ALL.</li>
          <li><strong>Participation aux activités extra</strong> : Les élèves sont encouragés à prendre part aux sessions spéciales (orientation, développement personnel, simulations de concours).</li>
          <li><strong>Esprit d'excellence</strong> : Chaque membre doit s'efforcer de cultiver la rigueur, la discipline et la motivation pour faire de SCHOOL FOR ALL un modèle de réussite.</li>
        </ol>
      </div>

      <div class="fiche-signature">
        J'ai lu et j'accepte toutes les conditions proposées par SCHOOL FOR ALL.
        &nbsp;&nbsp;&nbsp;Signature : ${caseACocher(false)}
      </div>
      <p style="text-align:right; font-size:9px; color:#888; margin-top:4px;">
        Réf. dossier n°${f.reference} — généré le ${f.date_inscription}
      </p>
    `;
    contenuFiche.innerHTML = html;
  }

  formulaireInscription.addEventListener('submit', async function (evenement) {
    evenement.preventDefault();
    messageConfirmation.classList.add('d-none');
    messageErreur.classList.add('d-none');

    if (!formulaireInscription.checkValidity()) {
      formulaireInscription.reportValidity();
      return;
    }

    boutonSubmit.disabled = true;
    boutonSubmit.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Envoi en cours…';

    try {
      const donneesFormulaire = new FormData(formulaireInscription);
      const reponse = await fetch('inscription-traiter.php', {
        method: 'POST',
        body: donneesFormulaire,
      });
      const resultat = await reponse.json();

      if (resultat.succes) {
        messageConfirmation.textContent = resultat.message;
        messageConfirmation.classList.remove('d-none');
        formulaireInscription.reset();

        numeroWhatsappActuel = resultat.numeroWhatsapp;
        recapitulatifActuel = resultat.recapitulatif;
        construireFiche(resultat.fiche);

        const modale = new bootstrap.Modal(document.getElementById('modaleFiche'));
        modale.show();
      } else {
        messageErreur.textContent = resultat.message || "Une erreur est survenue.";
        messageErreur.classList.remove('d-none');
      }
    } catch (erreur) {
      messageErreur.textContent = "Impossible de contacter le serveur. Veuillez réessayer.";
      messageErreur.classList.remove('d-none');
    } finally {
      boutonSubmit.disabled = false;
      boutonSubmit.innerHTML = '<i class="bi bi-whatsapp"></i> S\'inscrire';
    }
  });

  // ---------- Impression ----------
  document.getElementById('btnImprimerFiche').addEventListener('click', function () {
    window.print();
  });

  // ---------- Export PDF (jsPDF + html2canvas) ----------
  document.getElementById('btnTelechargerPdf').addEventListener('click', async function () {
    const bouton = this;
    const texteInitial = bouton.innerHTML;
    bouton.disabled = true;
    bouton.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Génération…';

    try {
      const zoneFiche = document.getElementById('ficheImpression');
      const canvas = await html2canvas(zoneFiche, { scale: 2, useCORS: true });
      const imageDonnees = canvas.toDataURL('image/png');

      const { jsPDF } = window.jspdf;
      const pdf = new jsPDF('p', 'mm', 'a4');
      const largeurPage = pdf.internal.pageSize.getWidth();
      const hauteurImage = (canvas.height * largeurPage) / canvas.width;

      pdf.addImage(imageDonnees, 'PNG', 0, 0, largeurPage, hauteurImage);
      pdf.save('fiche-inscription-school-for-all.pdf');
    } catch (erreur) {
      alert("Impossible de générer le PDF. Vous pouvez utiliser le bouton Imprimer à la place.");
    } finally {
      bouton.disabled = false;
      bouton.innerHTML = texteInitial;
    }
  });

  // ---------- Envoi WhatsApp (texte récapitulatif ; le PDF est à joindre manuellement) ----------
  document.getElementById('btnEnvoyerWhatsapp').addEventListener('click', function () {
    const messageWhatsapp = encodeURIComponent(recapitulatifActuel);
    window.open(`https://wa.me/${numeroWhatsappActuel}?text=${messageWhatsapp}`, '_blank');
  });
});

/**
 * SCHOOL FOR ALL — import-eleves.js
 * Lecture d'un fichier Excel/CSV côté client (SheetJS) pour importer
 * facilement une liste d'élèves depuis le tableau de bord administrateur.
 * Colonnes attendues : nom, prenom, classe, serie, numero_telephone, statut
 */
document.addEventListener('DOMContentLoaded', function () {
  const champFichier = document.getElementById('fichierImportEleves');
  if (!champFichier) return;

  const zoneApercu = document.getElementById('apercuImportEleves');
  const boutonValider = document.getElementById('btnValiderImport');
  let listeElevesImportes = [];

  champFichier.addEventListener('change', function (evenement) {
    const fichier = evenement.target.files[0];
    if (!fichier) return;

    const lecteur = new FileReader();
    lecteur.onload = function (e) {
      const classeur = XLSX.read(e.target.result, { type: 'binary' });
      const premiereFeuille = classeur.Sheets[classeur.SheetNames[0]];
      listeElevesImportes = XLSX.utils.sheet_to_json(premiereFeuille, { defval: '' });
      afficherApercuImport(listeElevesImportes);
    };
    lecteur.readAsBinaryString(fichier);
  });

  function afficherApercuImport(listeEleves) {
    if (!listeEleves.length) {
      zoneApercu.innerHTML = '<p class="text-danger">Aucune ligne détectée dans le fichier.</p>';
      boutonValider.disabled = true;
      return;
    }
    let html = '<div class="table-responsive"><table class="table table-sm table-bordered"><thead><tr>';
    Object.keys(listeEleves[0]).forEach(function (colonne) {
      html += `<th>${colonne}</th>`;
    });
    html += '</tr></thead><tbody>';
    listeEleves.slice(0, 20).forEach(function (ligne) {
      html += '<tr>' + Object.values(ligne).map(function (v) { return `<td>${v}</td>`; }).join('') + '</tr>';
    });
    html += '</tbody></table></div>';
    if (listeEleves.length > 20) {
      html += `<p class="small text-secondary">… et ${listeEleves.length - 20} ligne(s) supplémentaire(s).</p>`;
    }
    zoneApercu.innerHTML = html;
    boutonValider.disabled = false;
  }

  boutonValider.addEventListener('click', async function () {
    boutonValider.disabled = true;
    boutonValider.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Import en cours…';

    const reponse = await fetch('eleves-importer.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ eleves: listeElevesImportes }),
    });
    const resultat = await reponse.json();

    if (resultat.succes) {
      alert(`${resultat.nombreImportes} élève(s) importé(s) avec succès.`);
      window.location.reload();
    } else {
      alert(resultat.message || "Erreur lors de l'import.");
      boutonValider.disabled = false;
      boutonValider.textContent = 'Valider l\'import';
    }
  });
});

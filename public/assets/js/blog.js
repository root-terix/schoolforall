/**
 * SCHOOL FOR ALL — blog.js
 * Gère les interactions de type réseau social sur le blog : j'aime et commentaires.
 */
document.addEventListener('DOMContentLoaded', function () {

  // ---------- J'aime ----------
  document.querySelectorAll('.sfa-like-btn').forEach(function (bouton) {
    bouton.addEventListener('click', async function () {
      const articleId = bouton.dataset.articleId;
      const donnees = new FormData();
      donnees.append('article_id', articleId);

      const reponse = await fetch('blog-like.php', { method: 'POST', body: donnees });
      const resultat = await reponse.json();

      if (resultat.succes) {
        bouton.classList.toggle('active', resultat.actif);
        const icone = bouton.querySelector('i');
        icone.className = resultat.actif ? 'bi bi-hand-thumbs-up-fill' : 'bi bi-hand-thumbs-up';
        const compteurInline = bouton.querySelector('.nombre-likes');
        if (compteurInline) compteurInline.textContent = resultat.total;
        const compteurTotal = document.getElementById('nombreLikesTotal');
        if (compteurTotal) compteurTotal.textContent = resultat.total;
      }
    });
  });

  // ---------- Commentaires ----------
  const formulaireCommentaire = document.getElementById('formCommentaire');
  if (formulaireCommentaire) {
    formulaireCommentaire.addEventListener('submit', async function (evenement) {
      evenement.preventDefault();
      const donneesFormulaire = new FormData(formulaireCommentaire);

      const reponse = await fetch('blog-commentaire.php', { method: 'POST', body: donneesFormulaire });
      const resultat = await reponse.json();

      if (resultat.succes) {
        const listeCommentaires = document.getElementById('listeCommentaires');
        const nouveauCommentaire = document.createElement('div');
        nouveauCommentaire.className = 'mb-3 border-bottom pb-2';
        nouveauCommentaire.innerHTML = `
          <p class="fw-semibold mb-0 small">${resultat.nomAuteur}</p>
          <p class="mb-0">${resultat.contenu}</p>
          <p class="text-secondary small mb-0">${resultat.date}</p>`;
        listeCommentaires.appendChild(nouveauCommentaire);
        formulaireCommentaire.reset();
      } else {
        alert(resultat.message || "Impossible d'ajouter le commentaire.");
      }
    });
  }
});

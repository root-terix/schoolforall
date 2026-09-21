/**
 * SCHOOL FOR ALL — counters.js
 * Anime les chiffres clés (taux de réussite, statistiques) de 0 jusqu'à leur
 * valeur finale lorsqu'ils entrent dans la zone visible de l'écran.
 */
document.addEventListener('DOMContentLoaded', function () {
  const compteurs = document.querySelectorAll('.sfa-counter');
  if (!compteurs.length) return;

  const animerCompteur = function (element) {
    const valeurFinale = parseFloat(element.dataset.valeur || element.textContent);
    const suffixe = element.dataset.suffixe || '';
    const duree = 1400;
    const debut = performance.now();

    function etape(tempsActuel) {
      const progression = Math.min((tempsActuel - debut) / duree, 1);
      const progressionAdoucie = 1 - Math.pow(1 - progression, 3); // ease-out cubic
      const valeurActuelle = (valeurFinale * progressionAdoucie).toFixed(valeurFinale % 1 === 0 ? 0 : 1);
      element.textContent = valeurActuelle + suffixe;
      if (progression < 1) {
        requestAnimationFrame(etape);
      }
    }
    requestAnimationFrame(etape);
  };

  const observateur = new IntersectionObserver(function (entrees) {
    entrees.forEach(function (entree) {
      if (entree.isIntersecting) {
        animerCompteur(entree.target);
        observateur.unobserve(entree.target);
      }
    });
  }, { threshold: 0.4 });

  compteurs.forEach(function (compteur) {
    compteur.dataset.valeur = compteur.dataset.valeur || compteur.textContent;
    compteur.textContent = '0';
    observateur.observe(compteur);
  });
});

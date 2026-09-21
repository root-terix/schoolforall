/**
 * SCHOOL FOR ALL — main.js
 * Interactions générales du site public.
 */
document.addEventListener('DOMContentLoaded', function () {
  // Fermer automatiquement le menu mobile après un clic sur un lien
  const liensNav = document.querySelectorAll('#sfaNav .nav-link');
  const menuCollapse = document.getElementById('sfaNav');
  liensNav.forEach(function (lien) {
    lien.addEventListener('click', function () {
      if (menuCollapse.classList.contains('show')) {
        bootstrap.Collapse.getOrCreateInstance(menuCollapse).hide();
      }
    });
  });
});

# SCHOOL FOR ALL — Site web & tableau de bord

Code source complet du site institutionnel SCHOOL FOR ALL (Ebolowa, Cameroun), développé en
HTML5 / CSS3 (Bootstrap 5) / JavaScript / PHP / MySQL, conformément au cahier des charges et au
cahier de développement du projet.

## 1. Contenu du projet

```
schoolforall/
├── database/
│   └── schoolforall.sql        → script SQL complet (tables + données de démonstration)
├── config/
│   ├── config.php               → constantes de configuration (BDD, WhatsApp, uploads...)
│   └── bootstrap.php            → charge la config, le noyau et les modèles
├── core/
│   ├── Database.php             → connexion PDO (singleton)
│   └── Auth.php                 → authentification / session admin
├── app/models/                  → un modèle PHP par table (Eleve, Article, Epreuve, ...)
├── public/                      → site public (racine à pointer sur votre serveur web)
│   ├── index.php, cours.php, methode.php, equipe.php, resultats.php,
│   │   tarifs-planning.php, evenements.php, evenement-detail.php,
│   │   inscription.php, inscription-traiter.php, contact.php,
│   │   epreuves.php, orientation.php, blog.php, blog-detail.php,
│   │   blog-like.php, blog-commentaire.php
│   ├── includes/                → header.php / footer.php communs
│   └── assets/
│       ├── css/styles.css       → thème rose personnalisé (variables Bootstrap)
│       ├── js/                  → main.js, inscription.js, blog.js, import-eleves.js
│       └── uploads/             → photos, épreuves, événements, blog (générés à l'usage)
└── admin/                       → tableau de bord administrateur
    ├── login.php, logout.php, dashboard.php
    ├── blog.php                 → Module 1 : Newsletter / Blog (like, commentaires)
    ├── epreuves.php             → Module 2 : Épreuves & corrigés
    ├── eleves.php, eleves-importer.php → Module 3 : Import de la liste des élèves (Excel/CSV)
    ├── temoignages.php, resultats.php, planning-tarifs.php → Module 4
    ├── evenements.php           → Module 5 : Événements + galerie
    └── enseignants.php          → Gestion de l'équipe pédagogique
```

## 2. Installation (environnement local — XAMPP / WAMP / MAMP / LAMP)

1. Copiez le dossier `schoolforall/` dans le répertoire servi par votre serveur
   (ex. `htdocs/schoolforall` pour XAMPP).
2. Créez la base de données en important le script SQL :
   ```bash
   mysql -u root -p < database/schoolforall.sql
   ```
   (ou utilisez phpMyAdmin : "Importer" → sélectionner `database/schoolforall.sql`).
3. Ouvrez `config/config.php` et ajustez si besoin :
   - `DB_USER` / `DB_PASS` selon votre installation MySQL,
   - `SITE_URL` selon l'URL locale (ex. `http://localhost/schoolforall/public`),
   - `WHATSAPP_NUMBER` avec le vrai numéro WhatsApp de SCHOOL FOR ALL.
4. Vérifiez que le dossier `public/assets/uploads/` (et ses sous-dossiers `photos/`,
   `epreuves/`, `evenements/`, `blog/`) est accessible en écriture par le serveur web.
5. Ouvrez le site public : `http://localhost/schoolforall/public/`
6. Ouvrez le tableau de bord : `http://localhost/schoolforall/admin/`

## 3. Compte administrateur par défaut

| Champ         | Valeur                     |
|---------------|-----------------------------|
| E-mail        | admin@schoolforall.cm       |
| Mot de passe  | SchoolForAll2026             |

**⚠️ Important : changez ce mot de passe dès la première connexion** (créez un nouveau compte
administrateur via une requête SQL utilisant `password_hash()`, ou ajoutez une page de gestion
des comptes selon vos besoins).

## 4. Nouveautés de cette mise à jour

- **Thème rose animé** : dégradés inspirés du logo (rose/magenta), formes flottantes animées
  (rotation/translation) sur le hero, révélation au défilement via la librairie **AOS**
  (Animate On Scroll, chargée via CDN — aucune installation requise).
- **Tableau de bord administrateur repensé** : cartes statistiques en dégradé rose, et 4
  graphiques **Chart.js** connectés à de vraies données (courbe des inscriptions, anneaux
  « nouveaux vs anciens » et « élèves par niveau », barres « inscriptions par jour »).
- **Écosystème de l'équipe** (`public/equipe.php`) : organigramme animé avec un nœud central
  (dirigeant) relié par des liens SVG animés à chaque membre de l'équipe. Éditable depuis
  `admin/enseignants.php` (champs "Poste" et "Responsable hiérarchique").
- **Fiche d'inscription imprimable / PDF / WhatsApp** : après inscription, une fenêtre modale
  affiche la fiche complète avec 3 actions : Imprimer (CSS `@media print`), Télécharger en PDF
  (**jsPDF** + **html2canvas**, génération 100 % côté navigateur), et Envoyer sur WhatsApp
  (ouvre la conversation avec un récapitulatif texte — le PDF téléchargé doit être joint
  manuellement, WhatsApp Web ne permettant pas la jointure automatique depuis un site web).
- **Blog façon Facebook** : avatar de page, badge vérifié, horodatage relatif ("2 h", "3 j"),
  miniature systématique par publication, ligne de statistiques et barre d'actions
  J'aime / Commenter / Partager identique aux réseaux sociaux.
- **Épreuves en flux avec miniatures** : chaque sujet d'examen s'affiche comme une publication
  avec une miniature colorée (abréviation de l'examen), à la manière d'un fil d'actualité.

## 5. Mise à jour design — reproduction exacte des maquettes fournies (Header/Hero/Méthode/Why/Résultats/Footer/Fiche)

Cette mise à jour aligne le site sur les fichiers de référence fournis (`Header.jpg`, `Hero.jpg`,
`Methode.jpg`, `Why.jpg`, `Res.jpg`, `Footer.jpg`, `Logo.jpg`, `Fiche.jpg`) :

- **Logo** (`public/assets/img/logo.jpg`) intégré dans la navbar, le footer, la sidebar admin,
  la page de connexion admin, et en filigrane sur la fiche imprimable.
- **Header** : logo + menus déroulants « Nos cours », « Ressources », « Orientation » + bouton
  rose « S'inscrire », identiques à la maquette.
- **Hero** : animation 3D fluide sur la photo des élèves (rotation/translation continue en
  perspective CSS), icônes et pointillés décoratifs flottants.
- **Méthode SCHFL** : cercles multicolores (rose/bleu/jaune/teal/violet) reliés par une ligne en
  pointillés, avec animation de rotation + translation à l'apparition (au survol également).
- **Pourquoi nous choisir / Niveaux** : cartes en verre dépoli (glassmorphism — fond flou et
  semi-transparent) sur fond dégradé rose clair, pastilles de niveaux avec état actif rose plein.
- **Résultats / Témoignages / Événements** : tuiles de résultats colorées (rose/bleu/jaune/teal),
  carrousel de témoignages avec flèches et indicateurs à points, liste d'événements avec
  vignette + bouton « EN SAVOIR PLUS » en contour rose.
- **Footer** : fond très sombre, logo rond bordé de rose, icônes réseaux sociaux en couleur
  (Facebook bleu, WhatsApp vert, Instagram dégradé, YouTube rouge), colonnes Navigation /
  Ressources / Orientation / Contact, barre inférieure rose pleine.
- **Fiche d'inscription imprimable** (page `inscription.php`, générée après soumission du
  formulaire) : reproduction fidèle du document officiel — en-tête bilingue Cameroun
  (Ministère / Republic of Cameroon), logo centré, encadré photo 4x4, tous les champs de la
  fiche papier, cases à cocher Statut / Difficulté scolaire cochées automatiquement selon les
  réponses du formulaire, règlement intérieur en 20 points sur deux colonnes, ligne de
  signature, et filigrane du logo en arrière-plan. Cette fiche est imprimable, exportable en
  PDF et envoyable sur WhatsApp (voir section 4 ci-dessus).
- **Animations de défilement** : la librairie AOS reste utilisée sur l'ensemble des sections
  (fade, flip, zoom) pour un défilement fluide et élégant, en complément des animations CSS
  personnalisées (flottement, rotation, pulsation) propres à cette mise à jour.

### Fichier logo à remplacer si besoin
Si vous fournissez une version haute résolution ou détourée (fond transparent) du logo par la
suite, remplacez simplement `public/assets/img/logo.jpg` par le nouveau fichier (en conservant
le même nom, ou en mettant à jour les chemins dans `header.php`, `footer.php`,
`admin/includes/admin-header.php`, `admin/login.php` et `assets/js/inscription.js`).


- Architecture inspirée du pattern MVC : modèles dans `app/models/`, vues directement dans
  `public/*.php` et `admin/*.php` (voir le cahier de développement pour le détail des conventions).
- Toutes les requêtes SQL utilisent des requêtes préparées PDO.
- Le formulaire d'inscription envoie automatiquement un récapitulatif vers WhatsApp
  (lien click-to-chat `wa.me`) après enregistrement en base de données.
- L'import d'élèves se fait entièrement côté client (bibliothèque **SheetJS**), puis les données
  sont envoyées au serveur en JSON pour être enregistrées.
- Le blog dispose de fonctionnalités sociales : j'aime (par visiteur, via un identifiant de
  session), commentaires, partage de lien.
- Bootstrap 5 et Bootstrap Icons sont chargés via CDN ; aucune installation npm n'est nécessaire
  pour démarrer rapidement. Pour un usage hors-ligne, téléchargez les fichiers et adaptez les
  chemins dans `includes/header.php` et `admin/includes/admin-header.php`.

## 6. Mise en production

- Passez `MODE_DEBUG` à `false` dans `config/config.php`.
- Activez HTTPS et mettez à jour `SITE_URL`.
- Vérifiez les droits d'écriture du dossier `uploads/` sur le serveur de production.
- Sauvegardez régulièrement la base de données (`mysqldump`).

---
Document de référence complémentaire : voir le **Cahier des charges** et le **Cahier de
développement** fournis séparément pour le détail fonctionnel et les conventions de code.

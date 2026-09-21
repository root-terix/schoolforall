-- =====================================================================
-- SCHOOL FOR ALL — Base de données
-- Généré selon le dictionnaire de données du cahier de développement
-- Moteur : MySQL 8 / MariaDB 10+
-- =====================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS schoolforall
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE schoolforall;

-- ---------------------------------------------------------------------
-- Table administrateurs
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS administrateurs;
CREATE TABLE administrateurs (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    nom_complet   VARCHAR(100) NOT NULL,
    email         VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe  VARCHAR(255) NOT NULL,
    role          ENUM('super_admin','gestionnaire') NOT NULL DEFAULT 'gestionnaire',
    cree_le       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Compte par défaut : email admin@schoolforall.cm / mot de passe : SchoolForAll2026
-- (mot de passe haché avec password_hash() en PHP - bcrypt)
INSERT INTO administrateurs (nom_complet, email, mot_de_passe, role) VALUES
('Administrateur Principal', 'admin@schoolforall.cm', '$2b$12$XeBbL2FRToia9Pe4D.enZ.loxoS4FshLth4PEJzkpiB5e1G9mlDhC', 'super_admin');

-- ---------------------------------------------------------------------
-- Table eleves (inscriptions)
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS eleves;
CREATE TABLE eleves (
    id                       INT AUTO_INCREMENT PRIMARY KEY,
    photo                    VARCHAR(255) DEFAULT NULL,
    nom                      VARCHAR(100) NOT NULL,
    prenom                   VARCHAR(100) NOT NULL,
    date_naissance           DATE DEFAULT NULL,
    lieu_naissance           VARCHAR(150) DEFAULT NULL,
    nationalite              VARCHAR(80) DEFAULT NULL,
    numero_telephone         VARCHAR(20) DEFAULT NULL,
    etablissement            VARCHAR(150) DEFAULT NULL,
    classe                   VARCHAR(20) NOT NULL,
    serie                    VARCHAR(20) DEFAULT NULL,
    annee_scolaire           VARCHAR(20) DEFAULT NULL,
    statut                   ENUM('nouveau','ancien') NOT NULL DEFAULT 'nouveau',
    adresse                  VARCHAR(255) DEFAULT NULL,
    date_debut_cours         DATE DEFAULT NULL,
    contact_urgence_nom      VARCHAR(100) DEFAULT NULL,
    contact_urgence_numero   VARCHAR(20) DEFAULT NULL,
    contact_urgence_adresse  VARCHAR(255) DEFAULT NULL,
    moyen_decouverte         VARCHAR(150) DEFAULT NULL,
    a_difficulte_scolaire    TINYINT(1) NOT NULL DEFAULT 0,
    details_difficulte       TEXT DEFAULT NULL,
    projet_carriere          TEXT DEFAULT NULL,
    reglement_accepte        TINYINT(1) NOT NULL DEFAULT 0,
    source_import            ENUM('formulaire','import_admin') NOT NULL DEFAULT 'formulaire',
    cree_le                  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Table enseignants
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS enseignants;
CREATE TABLE enseignants (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    nom_complet     VARCHAR(100) NOT NULL,
    photo           VARCHAR(255) DEFAULT NULL,
    matiere         VARCHAR(100) NOT NULL,
    poste           VARCHAR(100) DEFAULT NULL COMMENT 'Ex: Directeur, Coordonnateur, Enseignant',
    responsable_id  INT DEFAULT NULL COMMENT 'Référence hiérarchique (écosystème équipe)',
    qualifications  VARCHAR(255) DEFAULT NULL,
    parcours        TEXT DEFAULT NULL,
    cree_le         DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (responsable_id) REFERENCES enseignants(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Table articles_blog / commentaires / likes
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS articles_blog;
CREATE TABLE articles_blog (
    id                 INT AUTO_INCREMENT PRIMARY KEY,
    titre              VARCHAR(200) NOT NULL,
    contenu            TEXT NOT NULL,
    image              VARCHAR(255) DEFAULT NULL,
    administrateur_id  INT DEFAULT NULL,
    est_publie         TINYINT(1) NOT NULL DEFAULT 1,
    cree_le            DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    modifie_le         DATETIME DEFAULT NULL,
    FOREIGN KEY (administrateur_id) REFERENCES administrateurs(id) ON DELETE SET NULL
) ENGINE=InnoDB;

DROP TABLE IF EXISTS commentaires;
CREATE TABLE commentaires (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    article_id    INT NOT NULL,
    nom_auteur    VARCHAR(100) NOT NULL,
    contenu       TEXT NOT NULL,
    est_valide    TINYINT(1) NOT NULL DEFAULT 1,
    cree_le       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (article_id) REFERENCES articles_blog(id) ON DELETE CASCADE
) ENGINE=InnoDB;

DROP TABLE IF EXISTS likes;
CREATE TABLE likes (
    id                    INT AUTO_INCREMENT PRIMARY KEY,
    article_id            INT NOT NULL,
    identifiant_visiteur  VARCHAR(100) NOT NULL,
    cree_le               DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_like (article_id, identifiant_visiteur),
    FOREIGN KEY (article_id) REFERENCES articles_blog(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Table epreuves
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS epreuves;
CREATE TABLE epreuves (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    type_examen      ENUM('BEPC','Probatoire','Baccalaureat','ETNS') NOT NULL,
    matiere          VARCHAR(80) NOT NULL,
    annee            YEAR NOT NULL,
    fichier_sujet    VARCHAR(255) DEFAULT NULL,
    fichier_corrige  VARCHAR(255) DEFAULT NULL,
    cree_le          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Table temoignages
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS temoignages;
CREATE TABLE temoignages (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nom_auteur  VARCHAR(100) NOT NULL,
    statut      VARCHAR(100) DEFAULT NULL,
    contenu     TEXT NOT NULL,
    photo       VARCHAR(255) DEFAULT NULL,
    cree_le     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Table resultats
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS resultats;
CREATE TABLE resultats (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    type_examen    ENUM('BEPC','Probatoire','Baccalaureat','ETNS') NOT NULL,
    annee          YEAR NOT NULL,
    taux_reussite  DECIMAL(5,2) NOT NULL,
    UNIQUE KEY uniq_resultat (type_examen, annee)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Table planning
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS planning;
CREATE TABLE planning (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    niveau       VARCHAR(20) NOT NULL,
    jour_semaine ENUM('Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche') NOT NULL,
    heure_debut  TIME NOT NULL,
    heure_fin    TIME NOT NULL,
    lieu         VARCHAR(150) DEFAULT NULL
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Table tarifs
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS tarifs;
CREATE TABLE tarifs (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    niveau       VARCHAR(20) NOT NULL,
    montant      DECIMAL(10,2) NOT NULL,
    periodicite  ENUM('mensuel','trimestriel','annuel') NOT NULL DEFAULT 'mensuel',
    conditions   VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Table evenements / evenement_images
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS evenements;
CREATE TABLE evenements (
    id                INT AUTO_INCREMENT PRIMARY KEY,
    titre             VARCHAR(200) NOT NULL,
    description       TEXT DEFAULT NULL,
    date_evenement    DATE NOT NULL,
    lieu              VARCHAR(150) DEFAULT NULL,
    image_couverture  VARCHAR(255) DEFAULT NULL,
    cree_le           DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

DROP TABLE IF EXISTS evenement_images;
CREATE TABLE evenement_images (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    evenement_id  INT NOT NULL,
    chemin_image  VARCHAR(255) NOT NULL,
    FOREIGN KEY (evenement_id) REFERENCES evenements(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================================
-- Données de démonstration
-- =====================================================================

INSERT INTO resultats (type_examen, annee, taux_reussite) VALUES
('Baccalaureat', 2024, 92.00),
('Probatoire', 2024, 89.00),
('BEPC', 2024, 95.00),
('ETNS', 2024, 88.00);

INSERT INTO temoignages (nom_auteur, statut, contenu) VALUES
('Sarah K.', 'Bachelière 2024', 'Grâce à SCHOOL FOR ALL, j''ai amélioré mes notes et j''ai eu mon Baccalauréat avec mention. Les enseignants sont vraiment à l''écoute.');

INSERT INTO tarifs (niveau, montant, periodicite, conditions) VALUES
('6ème', 15000.00, 'mensuel', NULL),
('Terminale', 20000.00, 'mensuel', 'Ordinateur requis pour la spécialité TI');

INSERT INTO planning (niveau, jour_semaine, heure_debut, heure_fin, lieu) VALUES
('Terminale', 'Samedi', '08:00:00', '12:00:00', 'Quartier Centre, Ebolowa');

INSERT INTO enseignants (nom_complet, matiere, poste, responsable_id, qualifications) VALUES
('Dr. Jean MBALLA', 'Direction', 'Fondateur & Directeur', NULL, 'Docteur en Sciences de l''Éducation');
INSERT INTO enseignants (nom_complet, matiere, poste, responsable_id, qualifications) VALUES
('Marie ATANGANA', 'Mathématiques', 'Coordonnatrice pédagogique', 1, 'Master en Mathématiques'),
('Paul ONDOA', 'Physique-Chimie', 'Enseignant', 1, 'Licence en Physique'),
('Chantal EYENGA', 'Français / Lettres', 'Enseignante', 1, 'Master en Lettres Modernes'),
('Serge NKOU', 'Anglais', 'Enseignant', 1, 'Licence en Anglais');

INSERT INTO evenements (titre, description, date_evenement, lieu) VALUES
('Olympiade SCHOOL FOR ALL', 'Compétition annuelle inter-niveaux.', '2026-09-15', 'Ebolowa'),
('Cérémonie de distinction', 'Remise des prix aux meilleurs élèves.', '2026-09-30', 'Ebolowa'),
('Tournoi Interclasses', 'Activités sportives et culturelles.', '2026-10-12', 'Ebolowa');

SET FOREIGN_KEY_CHECKS = 1;

<?php
/**
 * Bootstrap : charge la configuration, les classes du noyau et les modèles.
 * À inclure en tout premier dans chaque page publique ou d'administration.
 */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Auth.php';

foreach (glob(__DIR__ . '/../app/models/*.php') as $fichierModele) {
    require_once $fichierModele;
}

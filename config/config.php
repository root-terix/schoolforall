<?php
/**
 * SCHOOL FOR ALL - Fichier de configuration
 * Centralise toutes les constantes utilisées par l'application.
 * Adapter les valeurs ci-dessous selon l'environnement (dev / production).
 */

// ---------------------------------------------------------------------
// Base de données
// ---------------------------------------------------------------------
define('DB_HOST', 'localhost');
define('DB_NAME', 'schoolforall');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// ---------------------------------------------------------------------
// Site
// ---------------------------------------------------------------------
define('SITE_URL', 'http://localhost/schoolforall/public');
define('SITE_NAME', 'SCHOOL FOR ALL');

// ---------------------------------------------------------------------
// WhatsApp (numéro sans le "+", format international)
// ---------------------------------------------------------------------
define('WHATSAPP_NUMBER', '237699090231');

// ---------------------------------------------------------------------
// Uploads
// ---------------------------------------------------------------------
define('UPLOAD_PATH', __DIR__ . '/../public/assets/uploads/');
define('UPLOAD_URL', SITE_URL . '/assets/uploads/');
define('UPLOAD_MAX_SIZE', 5 * 1024 * 1024); // 5 Mo
define('ALLOWED_IMAGE_EXTENSIONS', ['jpg', 'jpeg', 'png', 'webp']);
define('ALLOWED_DOCUMENT_EXTENSIONS', ['pdf', 'doc', 'docx']);

// ---------------------------------------------------------------------
// Sécurité / session
// ---------------------------------------------------------------------
define('SESSION_NAME', 'sfa_admin_session');
define('PASSWORD_ALGO', PASSWORD_BCRYPT);

// ---------------------------------------------------------------------
// Affichage des erreurs (mettre à false en production)
// ---------------------------------------------------------------------
define('MODE_DEBUG', true);

if (MODE_DEBUG) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}

date_default_timezone_set('Africa/Douala');

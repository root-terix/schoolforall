<?php
require_once __DIR__ . '/../config/bootstrap.php';
Auth::deconnecter();
header('Location: login.php');
exit;

<?php
require_once __DIR__ . '/classes/Auth.php';

$auth = new Auth();
$auth->logout();

// Redirection vers la page d'accueil
header("Location: index.php");
exit;
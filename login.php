<?php
require_once __DIR__ . '/classes/Auth.php';

$auth = new Auth();

if (!empty($_POST['username']) && !empty($_POST['password'])) {
    if ($auth->login($_POST['username'], $_POST['password'])) {
        header("Location: index.php");
        exit;
    } else {
        echo "Identifiants incorrects.";
    }
} else {
    echo "Veuillez remplir tous les champs.";
}

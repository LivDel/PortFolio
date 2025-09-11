<?php
require_once __DIR__ . '/classes/Auth.php';

$auth = new Auth();

if (!empty($_POST['username']) && !empty($_POST['password'])) {
    if ($auth->register($_POST['username'], $_POST['password'])) {
        echo "Inscription réussie ! <a href='index.php'>Se connecter</a>";
    } else {
        echo "Nom d'utilisateur déjà pris.";
    }
} else {
    echo "Veuillez remplir tous les champs.";
}

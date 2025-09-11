<?php
// /classes/Auth.php
require_once __DIR__ . '/Session.php';
require_once __DIR__ . '/Database.php';

class Auth {
    private $session;
    private $conn;

    public function __construct() {
        $this->session = new Session();
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function register($username, $password) {
        // Vérifie si l’utilisateur existe déjà
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            return false; // déjà existant
        }

        // Hash du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insertion
        $stmt = $this->conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        return $stmt->execute([$username, $hashedPassword]);
    }

    public function login($username, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $this->session->set('user', $user['username']);
            return true;
        }
        return false;
    }

    public function logout() {
        $this->session->remove('user');
    }

    public function isLoggedIn() {
        return $this->session->isLoggedIn();
    }

    public function getUsername() {
        return $this->session->get('user');
    }
}

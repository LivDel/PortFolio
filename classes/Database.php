<?php
class Database {
    private $host = "localhost";
    private $db_name = "portfolio";
    private $username = "root"; // par défaut dans Laragon
    private $password = "";     // mot de passe vide par défaut
    private $conn;

    public function getConnection() {
        if ($this->conn === null) {
            try {
                $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name};charset=utf8", $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erreur connexion DB : " . $e->getMessage());
            }
        }
        return $this->conn;
    }
}

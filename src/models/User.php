<?php
namespace models;

use config\Database;

class User {
    private $db;

    public function __construct() {
        $this->db = Database::get();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password) VALUES (?,?,?)");
        $stmt->execute([
            $data['username'],
            $data['email'],
            password_hash($data['pass'], PASSWORD_DEFAULT)
        ]);
    }

    public function findByEmail($email) {
    $stmt = $this->db->prepare("
        SELECT id, username, email, password, role 
        FROM users 
        WHERE email = ?
    ");
    $stmt->execute([$email]);
    return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
<?php
namespace models;

use config\Database;

class Movie {
    private $db;

    public function __construct() {
        $this->db = Database::get();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM movies ORDER BY title");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM movies WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($title, $description) {
        $stmt = $this->db->prepare("INSERT INTO movies (title, description) VALUES (?, ?)");
        $stmt->execute([$title, $description]);
    }

    public function update($id, $title, $description) {
        $stmt = $this->db->prepare("UPDATE movies SET title = ?, description = ? WHERE id = ?");
        $stmt->execute([$title, $description, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM movies WHERE id = ?");
        $stmt->execute([$id]);
    }
}
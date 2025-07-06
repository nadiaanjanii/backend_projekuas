<?php
class Student {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM students");
        return $stmt->fetchAll();
    }

    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->pdo->prepare("INSERT INTO students (name) VALUES (?)");
        $stmt->execute([$data['name']]);
    }

    public function update($id, $data) {
        $stmt = $this->pdo->prepare("UPDATE students SET name = ? WHERE id = ?");
        $stmt->execute([$data['name'], $id]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM students WHERE id = ?");
        $stmt->execute([$id]);
    }
}

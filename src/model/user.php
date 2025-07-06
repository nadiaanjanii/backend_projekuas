<?php
class User {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    public function attemptLogin($username, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username=? AND password=MD5(?)");
        $stmt->execute([$username, $password]);
        return $stmt->fetch();
    }

    public function saveToken($id, $token) {
        $stmt = $this->pdo->prepare("UPDATE users SET token=? WHERE id=?");
        $stmt->execute([$token, $id]);
    }

    public function findByToken($token) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE token = ?");
        $stmt->execute([$token]);
        return $stmt->fetch();
    }
}

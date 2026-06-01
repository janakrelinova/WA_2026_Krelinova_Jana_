<?php
// app/models/User.php

class User {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;    
    }

    // Najde uživatele podle e-mailu (ochrana proti duplicitám)
    public function findByEmail(string $email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Zápis nového uživatele do databáze (Podle učitelova standardu)
    public function register(string $username, string $email, string $password): bool {
        // Pokud e-mail už v DB existuje, registraci zrušíme
        if ($this->findByEmail($email)) {
            return false; 
        }

        // ZABEZPEČENÍ: Vytvoření bezpečného hashe z čistého hesla
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->db->prepare($sql);

        // Bezpečné spuštění bez SQL injection
        return $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $hashedPassword
        ]);
    }

    // Načte jednoho uživatele podle ID (pro profil nebo administraci)
    public function readOne($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Aktualizuje údaje uživatele (přezdívku a email)
    public function update($id, $username, $email) {
        $sql = "UPDATE users SET username = :username, email = :email WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':username' => htmlspecialchars($username),
            ':email' => htmlspecialchars($email)
        ]);
    }

    // Načte seznam všech uživatelů (pro administrátora)
    public function readAll() {
        $sql = "SELECT id, username, email, is_admin FROM users ORDER BY id DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Smaže uživatele z databáze
    public function delete($id) {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
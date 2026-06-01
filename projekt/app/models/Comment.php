<?php

class Comment {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    // Načte všechny komentáře pro jeden konkrétní výlet 
    public function getByTripId($tripId) {
        $sql = "SELECT comments.*, users.username 
                FROM comments 
                JOIN users ON comments.user_id = users.id 
                WHERE comments.trip_id = :trip_id 
                ORDER BY comments.created_at DESC";
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':trip_id' => $tripId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Uloží nový komentář
    public function create($tripId, $userId, $text) {
        $sql = "INSERT INTO comments (trip_id, user_id, text) VALUES (:trip_id, :user_id, :text)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':trip_id' => $tripId,
            ':user_id' => $userId,
            ':text' => htmlspecialchars($text) // Ochrana proti XSS podle učitele!
        ]);
    }

    // Najde jeden konkrétní komentář (pro kontrolu autora před smazáním)
    public function readOne($id) {
        $sql = "SELECT * FROM comments WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Smaže komentář
    public function delete($id) {
        $sql = "DELETE FROM comments WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // Upraví text existujícího komentáře
    public function update($id, $text) {
        $sql = "UPDATE comments SET text = :text WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id'   => $id,
            ':text' => htmlspecialchars($text) // Ochrana proti XSS
        ]);
    }
}
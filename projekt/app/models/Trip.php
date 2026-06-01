<?php
// app/models/Trip.php

class Trip {
    // Definujeme vlastnost pro uložení databáze
    private PDO $db;

    // Konstruktor správně přijme připojení a uloží ho do $this->db
    public function __construct(PDO $db) {
        $this->db = $db;
    }

   
    public function create($title, $description, $location, $difficulty, $image, $userId, $mapUrl = null) {
        
        $sql = "INSERT INTO trips (title, description, location, difficulty, image, user_id, map_url) 
                VALUES (:title, :description, :location, :difficulty, :image, :user_id, :map_url)";
                
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            ':title' => htmlspecialchars($title),
            ':description' => htmlspecialchars($description),
            ':location' => htmlspecialchars($location),
            ':difficulty' => htmlspecialchars($difficulty),
            ':image' => $image,
            ':user_id' => $userId,
            ':map_url' => !empty($mapUrl) ? filter_var($mapUrl, FILTER_SANITIZE_URL) : null
        ]);
    }

    // Načtení všech výletů s volitelným filtrem obtížnosti
    public function readAll($difficulty = null) {
        // Základní dotaz pro načtení všech výletů
        $sql = "SELECT * FROM trips";
        
        // Pokud uživatel zvolil filtr, přidáme podmínku WHERE
        if (!empty($difficulty)) {
            $sql .= " WHERE difficulty = :difficulty";
        }
        
        $sql .= " ORDER BY id DESC";
        
        $stmt = $this->db->prepare($sql);
        
        if (!empty($difficulty)) {
            $stmt->execute([':difficulty' => $difficulty]);
        } else {
            $stmt->execute();
        }
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    // Přijímá pouze 2 argumenty ($id a pole $data)
    public function update($id, $data) {
      
        $sql = "UPDATE trips SET 
                    title = :title, 
                    description = :description, 
                    location = :location, 
                    difficulty = :difficulty, 
                    image = :image,
                    updated_by = :updated_by,
                    map_url = :map_url
                WHERE id = :id";
                
        $stmt = $this->db->prepare($sql);
        
        // Vytáhneme hodnoty z pole $data, které nám poslal controller
        return $stmt->execute([
            ':id' => $id,
            ':title' => htmlspecialchars($data['title']),
            ':description' => htmlspecialchars($data['description']),
            ':location' => htmlspecialchars($data['location']),
            ':difficulty' => htmlspecialchars($data['difficulty']),
            ':image' => $data['image'],
            ':updated_by' => $data['updated_by'], 
            ':map_url' => filter_var($data['map_url'], FILTER_SANITIZE_URL)
        ]);
    }

    // Metoda pro smazání výletu
    public function delete($id) {
        $sql = "DELETE FROM trips WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // Načtení jednoho konkrétního výletu podle ID
    public function readOne($id) {
        $sql = "SELECT * FROM trips WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        // Použijeme fetch(), protože chceme jen jeden řádek (asociativní pole)
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
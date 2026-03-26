<?php
// Načtení základní třídy pro připojení k DB
require_once '../app/models/Database.php';

class Book {
    private $db;

    public function __construct() {
        // Při vytvoření objektu Book se automaticky připojíme k DB
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Metoda pro získání všech knih z databáze
    public function getAll() {
        // SQL dotaz pro výběr všech záznamů
        $query = "SELECT * FROM books ORDER BY id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        // Vrátí pole všech nalezených řádků
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
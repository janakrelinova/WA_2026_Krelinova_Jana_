<?php
class Database {
    // Nastavení pro místní server (XAMPP / MAMP)
    private $host = "localhost";
    private $db_name = "projekt"; 
    private $username = "root";      
    private $password = "";          
    public $conn;

    // Funkce pro vytvoření spojení
    public function getConnection() {
        $this->conn = null;

        try {
            // Používáme PDO - moderní a bezpečný způsob práce s DB
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            
            // Nastavení, aby nám správně fungovala čeština (háčky a čárky)
            $this->conn->exec("set names utf8");
            
            // Nastavení hlášení chyb, aby se nám v prohlížeči ukázalo, co je špatně
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch(PDOException $exception) {
            echo "Chyba připojení k databázi: " . $exception->getMessage();
        }

        return $this->conn;
    }
}

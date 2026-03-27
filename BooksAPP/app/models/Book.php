<?php

class Book {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function create(
        string $title, 
        string $author,
        string $category,
        string $subcategory,
        int $year,
        float $price,
        string $isbn,
        string $description,
        string $link,
        array $images
    ): bool {
        $sql = "INSERT INTO books (title, author, category, subcategory, year, price, isbn, description, link, images)
                VALUES (:title, :author, :category, :subcategory, :year, :price, :isbn, :description, :link, :images)";
        
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':title'       => $title,
            ':author'      => $author,
            ':category'    => $category,
            ':subcategory' => $subcategory ?:null,
            ':year'        => $year,
            ':price'       => $price,
            ':isbn'        => $isbn,
            ':description' => $description,
            ':link'        => $link,
            ':images'      => json_encode($images)
        ]);
    }
}
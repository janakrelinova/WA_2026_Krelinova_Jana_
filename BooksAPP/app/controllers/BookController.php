<?php 
// Načtení modelu, aby kontroler mohl pracovat s daty
require_once '../app/models/Book.php';

class BookController {

    // Metoda pro zobrazení seznamu knih
    public function index() {
        // Vytvoření objektu modelu
        $bookModel = new Book();
        
        // Získání všech knih z databáze
        $books = $bookModel->getAll();

        // Načtení souboru s HTML strukturou (pohled)
        require_once '../app/views/books/books_list.php';
    }

    // Metoda pro zobrazení formuláře pro přidání knihy
    public function create() {
        // Načtení souboru s formulářem
        require_once '../app/views/books/Book_Create.php';
    }
}
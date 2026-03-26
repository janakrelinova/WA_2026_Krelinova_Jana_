<?php 

class BookController {

    //Výchozí metoda pro zobrazení úvodní stranky
    public function index (){
        //V dalších krocích se zde přidá komunikace s Modelem pro získání
        //např.: načtení všech uložených knih

        //nyní se pouze načte připravený soubor s html strukturou
        require_once'../app/views/books/books_list.php'
    }
}
<?php

class BookController {

    // 0. Výchozí metoda pro zobrazení úvodní stránky
    public function index() {
        require_once '../app/models/Database.php';
        require_once '../app/models/Book.php';

        $database = new Database();
        $db = $database->getConnection();

        $bookModel = new Book($db);
        $books = $bookModel->getAll(); 
        
        require_once '../app/views/books/books_list.php';
    }

    // 1. Zobrazení formuláře pro přidání
    public function create() {
        if (!isset($_SESSION['user_id'])) {
        $this->addErrorMessage('Pro přidání knihy se musíte nejprve přihlásit.');
        header('Location: ' . BASE_URL . '/index.php?url=auth/login');
        exit;
        }
        // Doporučuji přejmenovat soubor na malé 'book_create.php' pro konzistenci
        require_once '../app/views/books/book_create.php';
    }

    // 2. Zpracování dat odeslaných z formuláře (Přidání)
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

             // !!! ZMĚNA: ZDE PŘIDÁME KONTROLU PŘIHLÁŠENÍ ---
            if (!isset($_SESSION['user_id'])) {
                $this->addErrorMessage('Pro uložení knihy musíte být přihlášeni.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/login');
                exit;
            }
            $userId = $_SESSION['user_id'];
            
            // 1. Získání a očištění dat
            $title = htmlspecialchars($_POST['title'] ?? '');
            $author = htmlspecialchars($_POST['author'] ?? '');
            $isbn = htmlspecialchars($_POST['isbn'] ?? '');
            $category = htmlspecialchars($_POST['category'] ?? '');
            $subcategory = htmlspecialchars($_POST['subcategory'] ?? '');
            $year = (int)($_POST['year'] ?? 0);
            $price = (float)($_POST['price'] ?? 0);
            $link = htmlspecialchars($_POST['link'] ?? '');
            $description = htmlspecialchars($_POST['description'] ?? '');

            // Zpracování obrázků
            $uploadedImages = $this->processImageUploads(); 

            // 2. Komunikace s databází
            require_once '../app/models/Database.php';
            require_once '../app/models/Book.php';

            $database = new Database();
            $db = $database->getConnection();

            $bookModel = new Book($db);
            $isSaved = $bookModel->create(
                $title, $author, $category, $subcategory, 
                $year, $price, $isbn, $description, $link, $uploadedImages,
                $userId // PŘEDÁVÁME ID UŽIVATELE
            );

            // 3. Vyhodnocení
            if ($isSaved) {
                $this->addSuccessMessage('Kniha byla úspěšně uložena do databáze.');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            } else {
                $this->addErrorMessage('Nastala chyba. Nepodařilo se uložit knihu do databáze.');
            }
            
        } else {
            $this->addNoticeMessage('Pro přidání knihy je nutné odeslat formulář.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }
    }

    // 3. Smazání existující knihy
    public function delete($id = null) {
    // 🔒 ZMĚNA: Kontrola autentizace. 
    // Pouze přihlášený uživatel může iniciovat proces mazání.
    if (!isset($_SESSION['user_id'])) {
        $this->addErrorMessage('Pro smazání knihy se musíte nejprve přihlásit.');
        header('Location: ' . BASE_URL . '/index.php?url=auth/login');
        exit;
    }

    // Kontrola, zda bylo v URL předáno ID
    if (!$id) {
        $this->addErrorMessage('Nebylo zadáno ID knihy ke smazání.');
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    // Načtení potřebných tříd a spojení s databází
    require_once '../app/models/Database.php';
    require_once '../app/models/Book.php';

    $database = new Database();
    $db = $database->getConnection();
    $bookModel = new Book($db);

    // 🛡️ ZMĚNA: Kontrola autorizace (vlastnictví).
    // Nejdříve musíme knihu načíst, abychom zjistili, kdo ji vytvořil.
    $book = $bookModel->getById($id);

    if (!$book) {
        $this->addErrorMessage('Kniha nebyla nalezena, pravděpodobně již byla smazána.');
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    // Ověříme, zda je aktuálně přihlášený uživatel autorem záznamu.
    if ($book['created_by'] !== $_SESSION['user_id']) {
        $this->addErrorMessage('Nemáte oprávnění smazat tuto knihu, protože nejste jejím autorem.');
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    // 🛡️ ZMĚNA: Teprve po úspěšném ověření totožnosti provedeme samotné smazání.
    $isDeleted = $bookModel->delete($id);

    // Vyhodnocení výsledku a přesměrování s notifikací
    if ($isDeleted) {
        $this->addSuccessMessage('Kniha byla trvale smazána z databáze.');
    } else {
        $this->addErrorMessage('Nastala chyba. Knihu se nepodařilo smazat.');
    }

    header('Location: ' . BASE_URL . '/index.php');
    exit;
    }

   // 4. Zobrazení formuláře pro úpravu existující knihy
    public function edit($id = null) {
        // 🔒 !!! ZMĚNA: Kontrola, zda je uživatel přihlášen. 
        // Pokud není, nepustíme ho ani k načítání dat z DB.
        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('Pro úpravu knihy se musíte nejprve přihlásit.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }
        
        
        // Kontrola, zda bylo v URL vůbec předáno nějaké ID
        if (!$id) {
            // Vyvolání červené notifikace pro kritickou chybu
            $this->addErrorMessage('Nebylo zadáno ID knihy k úpravě.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Načtení potřebných tříd a spojení s databází
        require_once '../app/models/Database.php';
        require_once '../app/models/Book.php';

        $database = new Database();
        $db = $database->getConnection();

        // Získání dat o konkrétní knize
        $bookModel = new Book($db);
        $book = $bookModel->getById($id); // Proměnná $book nyní obsahuje asociativní pole dat

        // Bezpečnostní kontrola: Zda kniha s daným ID vůbec existuje
        if (!$book) {
            // Pokud knihu někdo mezitím smazal, nebo uživatel zadal do URL neexistující ID
            $this->addErrorMessage('Požadovaná kniha nebyla v databázi nalezena.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // 🛡️ !!! ZMĚNA: Kontrola vlastnictví (Autorizace).
        // Ověříme, zda ID přihlášeného uživatele odpovídá ID autora uloženého u knihy.
        if ($book['created_by'] !== $_SESSION['user_id']) {
            $this->addErrorMessage('Nemáte oprávnění upravovat tuto knihu, protože nejste jejím autorem.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Pokud je vše v pořádku, načte se připravený soubor s HTML formulářem pro úpravy.
        // Šablona bude mít automaticky přístup k proměnné $book.
        require_once '../app/views/books/book_edit.php';
        }
    // 5. Zpracování dat odeslaných z editačního formuláře (Update)
    public function update($id = null) {
    // 1. Základní kontrola ID
    if (!$id) {
        $this->addErrorMessage('Nebylo zadáno ID knihy k aktualizaci.');
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // 2. Kontrola přihlášení
        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('Pro uložení změn se musíte nejprve přihlásit.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }

        // 3. Příprava modelu a databáze
        require_once '../app/models/Database.php';
        require_once '../app/models/Book.php';

        $database = new Database();
        $db = $database->getConnection();
        $bookModel = new Book($db);

        // 4. Načtení stávající knihy pro kontrolu vlastnictví
        $book = $bookModel->getById($id);

        // 5. KONTROLA VLASTNICTVÍ (Autorizace)
        if (!$book || $book['created_by'] !== $_SESSION['user_id']) {
            $this->addErrorMessage('Nemáte oprávnění ukládat změny u této knihy, protože nejste jejím autorem.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        } 

        // 6. Očištění dat z formuláře
        $title = htmlspecialchars($_POST['title'] ?? '');
        $author = htmlspecialchars($_POST['author'] ?? '');
        $isbn = htmlspecialchars($_POST['isbn'] ?? '');
        $category = htmlspecialchars($_POST['category'] ?? '');
        $subcategory = htmlspecialchars($_POST['subcategory'] ?? '');
        $year = (int)($_POST['year'] ?? 0);
        $price = (float)($_POST['price'] ?? 0);
        $link = htmlspecialchars($_POST['link'] ?? '');
        $description = htmlspecialchars($_POST['description'] ?? '');

        // 7. Zpracování nahrávání nových obrázků
        $uploadedImages = $this->processImageUploads(); 

        // 8. LOGIKA PRO ZÁCHRANU OBRÁZKŮ (Pokud uživatel nic nenahrál, použijeme staré)
        if (empty($uploadedImages)) {
            if (!empty($book['images'])) {
                $uploadedImages = json_decode($book['images'], true);
            } else {
                $uploadedImages = [];
            }
        }

        // 9. VOLÁNÍ MODELU - TADY JSOU TY DŮLEŽITÉ ZMĚNY!
        // Posíláme celkem 12 argumentů. Poslední je ID přihlášeného uživatele ze SESSION.
        $isUpdated = $bookModel->update(
            $id,              // 1
            $title,           // 2
            $author,          // 3
            $category,        // 4
            $subcategory,     // 5
            $year,            // 6
            $price,           // 7
            $isbn,            // 8
            $description,     // 9
            $link,            // 10
            $uploadedImages,  // 11
            $_SESSION['user_id'] // 12. ARGUMENT: Kdo to upravil (updated_by)
        );

        // 10. Vyhodnocení výsledku
        if ($isUpdated) {
            $this->addSuccessMessage('Kniha byla úspěšně upravena.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        } else {
            $this->addErrorMessage('Nastala chyba. Změny se nepodařilo uložit.');
            header('Location: ' . BASE_URL . '/index.php?url=book/edit/' . $id);
            exit;
        }
        
    } else {
        $this->addNoticeMessage('Pro úpravu knihy je nutné odeslat formulář.');
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }
    }
    // --- Pomocné metody pro systém notifikací ---

    protected function addSuccessMessage($message) {
        $_SESSION['messages']['success'][] = $message;
    }

    protected function addNoticeMessage($message) {
        $_SESSION['messages']['notice'][] = $message;
    }

    protected function addErrorMessage($message) {
        $_SESSION['messages']['error'][] = $message;
    }

    // --- Pomocná metoda pro zpracování nahrávání obrázků ---
    protected function processImageUploads() {
        $uploadedFiles = [];
        $uploadDir = __DIR__ . '/../../public/uploads/'; 
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            $fileCount = count($_FILES['images']['name']);

            for ($i = 0; $i < $fileCount; $i++) {
                if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                    $tmpName = $_FILES['images']['tmp_name'][$i];
                    $originalName = basename($_FILES['images']['name'][$i]);
                    $fileExtension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                    if (!in_array($fileExtension, $allowedExtensions)) {
                        continue; 
                    }

                    $newName = 'book_' . uniqid() . '_' . substr(md5(mt_rand()), 0, 4) . '.' . $fileExtension;
                    $targetFilePath = $uploadDir . $newName;

                    if (move_uploaded_file($tmpName, $targetFilePath)) {
                        $uploadedFiles[] = $newName; 
                    }
                }
            }
        }
        return $uploadedFiles;
    }

    public function show($id = null) {
    // 1. Kontrola, zda bylo ID předáno
    if (!$id) {
        $this->addErrorMessage('Nebylo zadáno ID knihy pro zobrazení detailu.');
        header("Location: " . BASE_URL . "/index.php");
        exit;
    }

    // 2. Připojení k databázi a vytvoření modelu (stejně jako to máš v metodě edit)
    require_once '../app/models/Database.php';
    require_once '../app/models/Book.php';

    $database = new Database();
    $db = $database->getConnection();
    $bookModel = new Book($db);

    // 3. Získání dat (používáme lokální proměnnou $bookModel, ne $this->bookModel)
    $book = $bookModel->getById($id);

    // 4. Kontrola, zda kniha existuje
    if (!$book) {
        $this->addErrorMessage('Požadovaná kniha nebyla nalezena.');
        header("Location: " . BASE_URL . "/index.php");
        exit;
    }

    // 5. Načtení pohledu (nezapomeň na správnou cestu s ../)
    require_once '../app/views/books/book_show.php';
    }
} // Tady třída správně končí
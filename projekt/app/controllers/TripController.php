<?php
class TripController {
    private $tripModel;
    private $commentModel; 

    public function __construct() {
        // ... tvůj stávající kód, kde načítáš Database a Trip model ...
        require_once '../app/models/Database.php';
        require_once '../app/models/Trip.php';
        
        // PŘIDEJ: Načtení souboru s modelem pro komentáře (zkontroluj si přesný název souboru, např. Comment.php)
        require_once '../app/models/Comment.php'; 

        $database = new Database();
        $db = $database->getConnection();

        $this->tripModel = new Trip($db);
        
        // Inicializace modelu pro komentáře
        $this->commentModel = new Comment($db); 
    }

    public function index() {
        // Získáme vybranou obtížnost z GET parametru (pokud neexistuje, bude prázdná)
        $selectedDifficulty = $_GET['difficulty'] ?? '';

        // Předáme filtr do modelu
        $trips = $this->tripModel->readAll($selectedDifficulty);

        // Načtení pohledů
        include '../app/views/layout/header.php';
        include '../app/views/trips/index.php'; 
        include '../app/views/layout/footer.php';
    }

    // Přidání nového výletu
    public function create() {
        // OCHRANA: Pokud uživatel není přihlášen, vyhodíme ho na login 
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['messages']['error'][] = "Pro přidání výletu se musíš nejprve přihlásit.";
            header("Location: index.php?action=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = htmlspecialchars($_POST['title']);
            $description = htmlspecialchars($_POST['description']);
            $location = htmlspecialchars($_POST['location']);
            $difficulty = htmlspecialchars($_POST['difficulty']);
            $mapUrl = trim($_POST['map_url'] ?? '');
            
            // Správné nahrání obrázku
            $uploadedImages = $this->processImageUploads(); 
            $imageName = $uploadedImages[0] ?? ''; 

            // TEĎ už správně definujeme $userId ze session PŘED voláním modelu
            $userId = $_SESSION['user_id'];

            // Volání modelu k uložení dat (pouze jednou)
            if ($this->tripModel->create($title, $description, $location, $difficulty, $imageName, $userId, $mapUrl)) {
                $_SESSION['messages']['success'][] = "Výlet byl úspěšně přidán!";
                header("Location: index.php");
                exit;
            }
        }

        include '../app/views/layout/header.php';
        include '../app/views/trips/create.php'; 
        include '../app/views/layout/footer.php';
    }

   public function delete($id) {
        // Pokud v session vůbec není user_id, okamžitý vyhazov!
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['messages']['error'][] = "Pro mazání výletů musíte být přihlášeni.";
            header("Location: index.php");
            exit;
        }

        $trip = $this->tripModel->readOne($id);
        if (!$trip) {
            $_SESSION['messages']['error'][] = "Výlet nebyl nalezen.";
            header("Location: index.php");
            exit;
        }

        $isAuthor = ($trip['user_id'] == $_SESSION['user_id']);
        $isAdmin  = (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1);

        if (!$isAuthor && !$isAdmin) {
            $_SESSION['messages']['error'][] = "Nemáš oprávnění smazat tento výlet.";
            header("Location: index.php");
            exit;
        }

        if ($this->tripModel->delete($id)) {
            $_SESSION['messages']['success'][] = "Výlet byl smazán.";
            header("Location: index.php");
            exit;
        }
    }

    public function edit($id) {
        // 1. Nastartujeme kontrolu přihlášení
        // Pokud v session vůbec není user_id, uživatel je host a nemá tu co dělat!
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['messages']['error'][] = "Pro úpravu výletů se musíte nejdříve přihlásit.";
            header("Location: index.php");
            exit;
        }

        $trip = $this->tripModel->readOne($id);
        if (!$trip) {
            $_SESSION['messages']['error'][] = "Výlet nenalezen.";
            header("Location: index.php");
            exit;
        }

        // 2. RADIKÁLNÍ KONTROLA: Pustíme dál POUZE tehdy, pokud se ID stoprocentně rovná
        // nebo pokud je uživatel admin.
        $isAuthor = ($trip['user_id'] == $_SESSION['user_id']);
        $isAdmin  = (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1);

        if (!$isAuthor && !$isAdmin) {
            $_SESSION['messages']['error'][] = "Nemáš oprávnění upravovat tento výlet.";
            header("Location: index.php");
            exit;
        }

        // 3. Zpracování formuláře
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $_POST;
            $data['image'] = $trip['image'];

            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $targetDir = "../public/images/trips/";
                $fileName = time() . "_" . basename($_FILES["image"]["name"]);
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetDir . $fileName)) {
                    $data['image'] = $fileName;
                }
            }

            $data['updated_by'] = $_SESSION['user_id'];

            if ($this->tripModel->update($id, $data)) {
                $_SESSION['messages']['success'][] = "Výlet upraven.";
                header("Location: index.php");
                exit;
            }
        }

        include '../app/views/layout/header.php';
        include '../app/views/trips/edit.php';
        include '../app/views/layout/footer.php';
    }

    public function show($id) {
        $trip = $this->tripModel->readOne($id);

        if (!$trip) {
            $_SESSION['messages']['error'][] = "Požadovaný výlet nebyl nalezen.";
            header("Location: index.php");
            exit;
        }

        $isTripAuthor = false;
        $isAdmin = false;

        // Podmínky se vyhodnotí JEDINĚ tehdy, pokud je v session vůbec uloženo user_id
        if (isset($_SESSION['user_id'])) {
            $isTripAuthor = ($_SESSION['user_id'] == $trip['user_id']);
            $isAdmin = (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1);
        }
        // ----------------------------------------------------------------

        $comments = $this->commentModel->getByTripId($id) ?? [];

        // Načtení pohledů
        include '../app/views/layout/header.php';
        include '../app/views/trips/show.php';
        include '../app/views/layout/footer.php';
    }

    // Pomocná metoda pro zpracování nahrávání obrázků 
    protected function processImageUploads() {
        $uploadedFiles = [];
        $uploadDir = __DIR__ . '/../../public/images/trips/'; 
        
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

                    $newName = 'trip_' . uniqid() . '.' . $fileExtension;
                    $targetFilePath = $uploadDir . $newName;

                    if (move_uploaded_file($tmpName, $targetFilePath)) {
                        $uploadedFiles[] = $newName; 
                    }
                }
            }
        }
        return $uploadedFiles;
    }
}
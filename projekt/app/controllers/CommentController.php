<?php
// app/controllers/CommentController.php

class CommentController {
    private $db;
    private $commentModel;

    public function __construct($db) {
        $this->db = $db;
        require_once '../app/models/Comment.php';
        $this->commentModel = new Comment($db);
    }

// Přidání komentáře
    public function create() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['messages']['error'][] = "Pro přidání komentáře se musíš přihlásit.";
            header("Location: index.php");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tripId = intval($_POST['trip_id']);
            $text = trim($_POST['text']);

            if (!empty($text)) {
                // !!! ZMĚNA TADY: Zabalili jsme to do podmínky, abychom měli jistotu, že DB vrátila true
                if ($this->commentModel->create($tripId, $_SESSION['user_id'], $text)) {
                    $_SESSION['messages']['success'][] = "Komentář byl úspěšně přidán.";
                } else {
                    $_SESSION['messages']['error'][] = "Chyba: Komentář se nepodařilo uložit do databáze.";
                }
            } else {
                $_SESSION['messages']['error'][] = "Komentář nesmí být prázdný.";
            }

            // !!! ZMĚNA TADY: Přidali jsme exit;, aby PHP po přesměrování okamžitě skončilo
            header("Location: index.php?action=show&id=" . $tripId);
            exit; 
        }
    }

    // Smazání komentáře 
    public function delete($id) {
        $comment = $this->commentModel->readOne($id);

        if (!$comment || !isset($_SESSION['user_id']) || $comment['user_id'] != $_SESSION['user_id']) {
            $_SESSION['messages']['error'][] = "Nemáš oprávnění smazat tento komentář.";
            header("Location: index.php");
            exit;
        }

        $this->commentModel->delete($id);
        $_SESSION['messages']['success'][] = "Komentář byl smazán.";
        header("Location: index.php?action=show&id=" . $comment['trip_id']);
        exit;
    }

    // Úprava komentáře (Zabezpečená – kontroluje autora!)
    public function edit($id) {
        $comment = $this->commentModel->readOne($id);

        // OCHRANA: Upravovat může jen přihlášený autor komentáře
        if (!$comment || !isset($_SESSION['user_id']) || $comment['user_id'] != $_SESSION['user_id']) {
            $_SESSION['messages']['error'][] = "Nemáš oprávnění upravovat tento komentář.";
            header("Location: index.php");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $text = trim($_POST['text'] ?? '');

            if (!empty($text)) {
                $this->commentModel->update($id, $text);
                $_SESSION['messages']['success'][] = "Komentář byl úspěšně upraven.";
            } else {
                $_SESSION['messages']['error'][] = "Komentář nesmí být prázdný.";
            }

            // Přesměrování zpět na detail výletu
            header("Location: index.php?action=show&id=" . $comment['trip_id']);
            exit;
        }

        // Pokud na akci přijdeme běžně (GET), načteme pomocnou stránku pro úpravu
        include '../app/views/layout/header.php';
        // Vytvoříme si jednoduché zobrazení pro editaci, ať nemusíme složitě míchat JavaScript do show.php
        ?>
        <div class="max-w-2xl mx-auto mt-20 bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <h2 class="text-2xl font-black text-gray-900 mb-2">Upravit svůj komentář</h2>
            <p class="text-gray-500 text-sm mb-6">Zde můžeš opravit text svého komentáře.</p>
            
            <form action="index.php?action=editComment&id=<?php echo $comment['id']; ?>" method="POST" class="space-y-4">
                <div>
                    <textarea name="text" rows="4" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#14643a] focus:outline-none text-sm"><?php echo htmlspecialchars($comment['text']); ?></textarea>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-[#14643a] text-white font-bold px-6 py-2.5 rounded-xl hover:bg-opacity-90 transition text-sm shadow-md">
                        Uložit změny
                    </button>
                    <a href="index.php?action=show&id=<?php echo $comment['trip_id']; ?>" class="bg-gray-100 text-gray-600 font-bold px-6 py-2.5 rounded-xl hover:bg-gray-200 transition text-sm">
                        Zrušit
                    </a>
                </div>
            </form>
        </div>
        <?php
        include '../app/views/layout/footer.php';
    }
}
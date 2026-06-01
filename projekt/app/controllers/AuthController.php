<?php
// app/controllers/AuthController.php

class AuthController {
    private $db;
    private $userModel;

    public function __construct($db) {
        $this->db = $db;
        // Načteme si User model
        require_once '../app/models/User.php';
        $this->userModel = new User($db);
    }

    public function register() {
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // OČIŠTĚNÍ VSTUPŮ PROTI XSS (Standard podle učitele)
            $username = htmlspecialchars($_POST['username'] ?? '');
            $email = htmlspecialchars($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            // Tvoje bezpečnostní podmínky na heslo
            if (strlen($password) < 8) {
                $error = "Heslo musí mít alespoň 8 znaků!";
            } elseif (!preg_match('/[0-9]/', $password)) {
                $error = "Heslo musí obsahovat alespoň jedno číslo!";
            } else {
                // Odeslání do modelu k uložení
                if ($this->userModel->register($username, $email, $password)) {
                    // Úspěch: Uložíme hlášku do Session a jdeme na přihlášení
                    $_SESSION['messages']['success'][] = "Registrace byla úspěšná! Nyní se můžeš přihlásit.";
                    header("Location: index.php?action=login");
                    exit;
                } else {
                    $error = "Uživatel s tímto e-mailem již v databázi existuje.";
                }
            }
        }

        include '../app/views/layout/header.php';
        include '../app/views/auth/register.php';
        include '../app/views/layout/footer.php';
    }

    public function login() {
        // Dočasná metoda, aby web nepadal, než napíšeme login vzhled
        include '../app/views/layout/header.php';
        include '../app/views/auth/login.php';
        include '../app/views/layout/footer.php';
    }

    // Zpracování přihlášení (Ověření hesla podle učitele)
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = htmlspecialchars($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            // Najdeme uživatele v DB podle e-mailu
            $user = $this->userModel->findByEmail($email);

            

        if ($user && password_verify($password, $user['password'])) {
             $_SESSION['user_id'] = $user['id'];
             $_SESSION['username'] = $user['username'];
    
            
            $_SESSION['is_admin'] = intval($user['is_admin']); 

                $_SESSION['messages']['success'][] = "Vítej zpět, " . $_SESSION['user_name'] . "!";
                header('Location: index.php');
                exit;
                
            } else {
                // CHYBA: Záměrně neříkáme, jestli byl špatně e-mail nebo heslo (Bezpečnost!)
                $_SESSION['messages']['error'][] = "Nesprávný e-mail nebo heslo.";
                header('Location: index.php?action=login');
                exit;
            }
        }
    }

    // Odhlášení uživatele 
    public function logout() {
        // Vymažeme uživatelská data ze Session
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        
        // Přidáme zelenou hlášku a pošleme ho na domovskou stránku
        $_SESSION['messages']['success'][] = "Byl jsi úspěšně odhlášen.";
        header('Location: index.php');
        exit;
    }

    // Zobrazení a úprava vlastního profilu (CRUD profilu)
    public function profile() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit;
        }

        $userId = $_SESSION['user_id'];
        
        // Pokud se odeslal formulář s úpravou
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');

            if (!empty($username) && !empty($email)) {
                $this->userModel->update($userId, $username, $email);
                $_SESSION['username'] = $username; // Aktualizujeme jméno i v Session, ať se hned změní v menu
                $_SESSION['messages']['success'][] = "Profil byl úspěšně aktualizován.";
            } else {
                $_SESSION['messages']['error'][] = "Všechna pole musí být vyplněna.";
            }
            header("Location: index.php?action=profile");
            exit;
        }

        // Načtení aktuálních dat pro zobrazení ve formuláři
        $user = $this->userModel->readOne($userId);
        
        // Pokud je uživatel ADMIN, načteme mu navíc seznam všech lidí pro administraci
        $allUsers = [];
        if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === 1) {
            $allUsers = $this->userModel->readAll();
        }

        include '../app/views/layout/header.php';
        // Vzhled profilu vložíme přímo sem, ať máme jistotu, že se správně načtou proměnné
        ?>
        <div class="max-w-4xl mx-auto mt-12 grid grid-cols-1 md:grid-cols-3 gap-8 px-4">
            <div class="md:col-span-1 bg-white p-6 rounded-3xl shadow-sm border border-gray-100 h-fit">
                <h2 class="text-xl font-black text-gray-900 mb-4">Můj profil</h2>
                <form action="index.php?action=profile" method="POST" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-400 mb-1">Přezdívka</label>
                        <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#14643a] focus:outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-400 mb-1">E-mail</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#14643a] focus:outline-none text-sm">
                    </div>
                    <button type="submit" class="w-full bg-[#14643a] text-white font-bold py-2.5 rounded-xl hover:bg-opacity-90 transition text-sm shadow-sm">
                        Uložit změny
                    </button>
                </form>
            </div>

            <div class="md:col-span-2 bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                <h2 class="text-xl font-black text-gray-900 mb-2">Správa uživatelů</h2>
                <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === 1): ?>
                    <p class="text-gray-400 text-xs mb-4">Jako administrátor máš právo mazat uživatelské účty.</p>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-sm">
                            <thead>
                                <tr class="border-b border-gray-100 text-gray-400 text-xs uppercase">
                                    <th class="pb-3 font-bold">Přezdívka</th>
                                    <th class="pb-3 font-bold">E-mail</th>
                                    <th class="pb-3 font-bold text-center">Akce</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 text-gray-700">
                                <?php foreach ($allUsers as $u): ?>
                                    <tr>
                                        <td class="py-3 font-medium">
                                            <?php echo htmlspecialchars($u['username']); ?>
                                            <?php if ($u['is_admin']): ?><span class="ml-1.5 px-2 py-0.5 bg-red-50 text-red-600 text-[10px] font-bold rounded-full border border-red-100">Admin</span><?php endif; ?>
                                        </td>
                                        <td class="py-3 text-gray-500"><?php echo htmlspecialchars($u['email'] ?? '---'); ?></td>
                                        <td class="py-3 text-center">
                                            <?php if ($u['id'] != $_SESSION['user_id']): ?>
                                                <a href="index.php?action=deleteUser&id=<?php echo $u['id']; ?>" onclick="return confirm('Opravdu chceš smazat tohoto uživatele a všechny jeho příspěvky?')" class="text-red-500 hover:underline font-bold text-xs">
                                                    Smazat
                                                </a>
                                            <?php else: ?>
                                                <span class="text-gray-300 text-xs">Tvůj účet</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-gray-400 text-sm py-8 text-center bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        🔒 Sekce je přístupná pouze pro administrátory.
                    </p>
                <?php endif; ?>
            </div>
        </div>
        <?php
        include '../app/views/layout/footer.php';
    }

    // Bezpečné smazání uživatele administrátorem (Oprávnění pro mazání)
    public function deleteUser($id) {
        // PŘÍSNÝ ZÁMEK: Pokud v Session chybí příznak admina nebo není roven 1, vyhodíme ho!
        if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== 1) {
            $_SESSION['messages']['error'][] = "Přístup odepřen. Tuto akci může provést pouze administrátor.";
            header("Location: index.php");
            exit;
        }

        // Zamezení smazání sebe sama přes podvržený odkaz
        if ($id == $_SESSION['user_id']) {
            $_SESSION['messages']['error'][] = "Nemůžeš smazat svůj vlastní účet, pod kterým jsi přihlášen/a.";
            header("Location: index.php?action=profile");
            exit;
        }

        $this->userModel->delete($id);
        $_SESSION['messages']['success'][] = "Uživatel byl úspěšně smazán z databáze.";
        header("Location: index.php?action=profile");
        exit;
    }
}
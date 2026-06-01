<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZaLESEM | Výlety</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">

    <header class="bg-white shadow-sm border-b-2 border-[#14643a] sticky top-0 z-50">
        <nav class="container mx-auto px-6 py-4 flex items-center justify-between">
            
            <div class="flex items-center gap-3">
                <img src="images/logo.png" alt="Logo" class="h-10 w-auto">
                <a href="index.php" class="text-2xl text-[#14643a] tracking-tight hover:opacity-90 transition">
                    Za<span class="font-black">LES</span>EM
                </a>
            </div>

            <div class="flex items-center gap-6">
                <a href="index.php" class="text-gray-600 hover:text-[#14643a] font-medium transition-colors">Domů</a>
                <a href="index.php" class="text-gray-600 hover:text-[#14643a] font-medium transition-colors">Výlety</a>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span class="text-gray-600 text-sm">
                        Ahoj, <strong class="text-[#14643a]"><?php echo htmlspecialchars($_SESSION['username'] ?? 'Uživatel'); ?></strong>! 👋
                    </span>
                    
                    <a href="index.php?action=profile" class="text-gray-600 hover:text-[#14643a] font-medium transition-colors">
                        Můj profil
                    </a>
                    
                    <a href="index.php?action=logout" class="text-gray-500 hover:text-red-600 font-bold transition-colors text-sm uppercase tracking-wider">
                        Odhlásit se
                    </a>
                <?php else: ?>
                    <a href="index.php?action=login" class="text-gray-600 hover:text-[#14643a] font-medium transition-colors">
                        Přihlásit
                    </a>
                    <a href="index.php?action=register" class="bg-[#14643a] text-white px-5 py-2 rounded-full font-bold hover:bg-opacity-90 transition shadow-md">
                        Registrace
                    </a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <div class="max-w-6xl mx-auto w-full px-6 pt-4">
        <?php if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])): ?>
            <div class="space-y-3">
                <?php foreach ($_SESSION['messages'] as $type => $messages): ?>
                    <?php 
                        $style = 'bg-gray-100 text-gray-700 border-gray-400';
                        if ($type === 'success') $style = 'bg-green-50 text-green-700 border-green-400';
                        if ($type === 'error') $style = 'bg-red-50 text-red-700 border-red-400';
                    ?>
                    <?php foreach ($messages as $message): ?>
                        <div class="<?= $style ?> border-l-4 p-4 rounded-r-xl shadow-sm font-bold text-sm">
                            <?php if ($type === 'success') echo '✅ '; ?>
                            <?php if ($type === 'error') echo '❌ '; ?>
                            <?php echo htmlspecialchars($message); ?>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                <?php unset($_SESSION['messages']); ?>
            </div>
        <?php endif; ?>
    </div>

    <main class="flex-grow container mx-auto px-6 py-10">
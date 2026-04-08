<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knihovna - Seznam knih</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Přidáme klasický "knižní" font pro ten správný old-school pocit */
        @import url('https://fonts.googleapis.com/css2?family=Crimson+Pro:wght@400;600;700&display=swap');
        body { font-family: 'Crimson Pro', serif; }
    </style>
</head>
<body class="bg-[#fcfaf2] text-stone-800 min-h-screen">

    <header class="border-b border-stone-200 bg-[#f8f5e9] py-8 shadow-sm">
        <div class="container mx-auto px-6 flex flex-col md:flex-row justify-between items-center">
            <div>
                <h1 class="text-4xl font-bold tracking-tight text-stone-900">Aplikace Knihovna</h1>
                <p class="text-stone-500 italic mt-1">Vaše osobní sbírka příběhů</p>
            </div>
            
            <nav class="mt-6 md:mt-0">
                <ul class="flex items-center space-x-8">
                    <li>
                        <a href="<?= BASE_URL ?>/index.php" class="hover:text-stone-600 transition-colors border-b border-stone-400 font-medium uppercase tracking-widest text-sm">Domů</a>
                    </li>
                    <li>
                        <a href="<?= BASE_URL ?>/index.php?url=book/create" class="bg-stone-800 text-stone-100 px-5 py-2 rounded-md hover:bg-stone-700 transition-colors shadow-sm uppercase tracking-wider text-xs font-bold">
                            + Přidat knihu
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container mx-auto px-6 py-12">
        
        <?php if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])): ?>
            <div class="mb-10 space-y-3 max-w-2xl mx-auto">
                <?php foreach ($_SESSION['messages'] as $type => $messages): ?>
                    <?php 
                        $colorClass = 'border-stone-300 bg-white text-stone-700';
                        if ($type === 'success') $colorClass = 'border-green-200 bg-green-50 text-green-800';
                        if ($type === 'error') $colorClass = 'border-red-200 bg-red-50 text-red-800';
                    ?>
                    <?php foreach ($messages as $message): ?>
                        <div class="p-4 border <?= $colorClass ?> rounded-md shadow-sm text-center italic text-lg">
                            <?= htmlspecialchars($message) ?>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                <?php unset($_SESSION['messages']); ?>
            </div>
        <?php endif; ?>

        <h2 class="text-2xl font-semibold text-stone-700 mb-8 border-l-4 border-stone-300 pl-4">Katalog knih</h2>
        
        <?php if (empty($books)): ?>
            <div class="text-center py-20 border-2 border-dashed border-stone-200 rounded-lg">
                <p class="text-stone-400 text-xl italic">Police jsou zatím prázdné...</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                <?php foreach ($books as $book): ?>
                    <div class="group bg-white border border-stone-200 rounded-md p-6 shadow-sm hover:shadow-md hover:border-stone-300 transition-all flex flex-col justify-between relative overflow-hidden">
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-stone-100 group-hover:bg-amber-200 transition-colors"></div>
                        
                        <div>
                            <div class="text-xs text-stone-400 font-mono mb-2 flex justify-between uppercase tracking-tighter">
                                <span>ID: <?= htmlspecialchars($book['id']) ?></span>
                                <span><?= htmlspecialchars($book['year']) ?></span>
                            </div>
                            
                            <h3 class="text-2xl font-bold text-stone-900 leading-tight mb-2 italic">
                                <?= htmlspecialchars($book['title']) ?>
                            </h3>
                            
                            <p class="text-stone-600 font-medium mb-4">
                                <span class="text-stone-400 font-normal uppercase text-[10px] tracking-widest block">Autor</span>
                                <?= htmlspecialchars($book['author']) ?>
                            </p>
                        </div>

                        <div class="mt-6 border-t border-stone-100 pt-4 flex justify-between items-end">
                            <div>
                                <span class="text-xs text-stone-400 uppercase tracking-widest block">Cena</span>
                                <span class="text-xl font-bold text-stone-800 font-mono italic">
                                    <?= htmlspecialchars($book['price']) ?> <small class="text-sm font-normal">Kč</small>
                                </span>
                            </div>
                            
                            <div class="flex space-x-3 text-stone-500">
                                <a href="<?= BASE_URL ?>/index.php?url=book/show/<?= $book['id'] ?>" class="hover:text-blue-600 transition-colors" title="Detail">👁️</a>
                                <a href="<?= BASE_URL ?>/index.php?url=book/edit/<?= $book['id'] ?>" class="hover:text-amber-600 transition-colors" title="Upravit">✏️</a>
                                <a href="<?= BASE_URL ?>/index.php?url=book/delete/<?= $book['id'] ?>" onclick="return confirm('Opravdu chcete tuto knihu smazat?')" class="hover:text-red-600 transition-colors" title="Smazat">🗑️</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <footer class="mt-20 py-10 bg-stone-100 border-t border-stone-200 text-stone-500">
        <div class="container mx-auto px-6 text-center">
            <p class="uppercase tracking-[0.2em] text-[10px] font-bold">&copy; <?= date('Y') ?> | Knihovna Jany Křelínové</p>
            <p class="italic text-xs mt-2 text-stone-400 underline decoration-stone-200 underline-offset-4 tracking-wider">Úkol 8 - Designová transformace</p>
        </div>
    </footer>

</body>
</html>
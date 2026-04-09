
<?php require_once '../app/views/layout/header.php'; ?>
    <main class="container mx-auto px-6 py-12">
        
        <?php if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])): ?>
            <div class="mb-10 space-y-4 max-w-3xl mx-auto">
                <?php foreach ($_SESSION['messages'] as $type => $messages): ?>
                    <?php 
                        $classes = 'flex items-center p-4 rounded-xl border';
                        if ($type === 'success') $classes .= ' bg-emerald-50 border-emerald-200 text-emerald-800';
                        elseif ($type === 'error') $classes .= ' bg-red-50 border-red-200 text-red-800';
                        else $classes .= ' bg-brand-light border-sky-200 text-brand-dark';
                    ?>
                    <?php foreach ($messages as $message): ?>
                        <div class="<?= $classes ?>" role="alert">
                            <span class="font-semibold"><?= htmlspecialchars($message) ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                <?php unset($_SESSION['messages']); ?>
            </div>
        <?php endif; ?>

        <div class="flex items-center justify-between mb-10 pb-4 border-b border-slate-100">
            <h2 class="text-4xl font-extrabold text-slate-950 tracking-tighter">Aktuální katalog</h2>
            <div class="text-sm text-slate-500 bg-slate-100 px-4 py-1.5 rounded-full font-medium">
                Celkem knih: <span class="font-bold text-brand"><?= count($books) ?></span>
            </div>
        </div>
        
        <?php if (empty($books)): ?>
            <div class="text-center py-24 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
                <span class="text-6xl mb-4 block">📭</span>
                <p class="text-slate-600 text-xl font-medium">V databázi zatím nejsou žádné knihy.</p>
                <a href="<?= BASE_URL ?>/index.php?url=book/create" class="mt-6 inline-block bg-brand text-white px-6 py-3 rounded-xl font-bold hover:bg-brand-dark transition">
                    Vytvořit první záznam
                </a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <?php foreach ($books as $book): ?>
                    <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm hover:shadow-lg hover:border-brand-light transition-all duration-300 flex flex-col justify-between group">
                        
                        <div>
                            <div class="flex justify-between items-start mb-4">
                                <span class="text-xs font-mono text-slate-400 bg-slate-50 px-2 py-1 rounded">#<?= htmlspecialchars($book['id']) ?></span>
                                <span class="text-sm font-bold text-brand bg-brand-light px-3 py-1 rounded-full"><?= htmlspecialchars($book['year']) ?></span>
                            </div>
                            
                            <h3 class="text-xl font-bold text-slate-950 leading-tight mb-1 group-hover:text-brand transition">
                                <?= htmlspecialchars($book['title']) ?>
                            </h3>
                            
                            <p class="text-slate-600 text-base font-medium mb-5">
                                <?= htmlspecialchars($book['author']) ?>
                            </p>
                        </div>

                        <div class="mt-4 pt-5 border-t border-slate-100 flex items-end justify-between">
                            <div>
                                <span class="text-xs text-slate-500 block uppercase tracking-wider font-semibold">Cena</span>
                                <span class="text-2xl font-extrabold text-slate-950 font-mono">
                                    <?= htmlspecialchars($book['price']) ?> <span class="text-lg font-normal text-slate-500">Kč</span>
                                </span>
                            </div>
                            
                            <div class="flex space-x-1.5">
                                <a href="<?= BASE_URL ?>/index.php?url=book/show/<?= $book['id'] ?>" class="bg-slate-100 text-slate-700 p-2.5 rounded-lg hover:bg-brand-light hover:text-brand-dark transition" title="Detail">👁️</a>
                                <a href="<?= BASE_URL ?>/index.php?url=book/edit/<?= $book['id'] ?>" class="bg-slate-100 text-slate-700 p-2.5 rounded-lg hover:bg-amber-100 hover:text-amber-800 transition" title="Upravit">✏️</a>
                                <a href="<?= BASE_URL ?>/index.php?url=book/delete/<?= $book['id'] ?>" onclick="return confirm('Opravdu chcete tuto knihu smazat?')" class="bg-slate-100 text-slate-700 p-2.5 rounded-lg hover:bg-red-100 hover:text-red-800 transition" title="Smazat">🗑️</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
<?php require_once '../app/views/layout/footer.php'; ?>
  
    
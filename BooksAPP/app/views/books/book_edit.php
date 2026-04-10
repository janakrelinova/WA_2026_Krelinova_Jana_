<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-6 py-12">
    <div class="max-w-4xl mx-auto">
        
        <div class="mb-10">
            <nav class="mb-4">
                 <a href="<?= BASE_URL ?>/index.php" class="text-brand font-bold text-sm uppercase tracking-widest hover:underline">← Seznam knih</a>
            </nav>
            <h2 class="text-4xl font-extrabold text-slate-950 tracking-tighter">Upravit knihu</h2>
            <p class="text-slate-500 text-lg mt-2 italic">
                Upravujete data pro: <span class="text-slate-900 font-bold"><?= htmlspecialchars($book['title']) ?></span> (ID: <?= htmlspecialchars($book['id']) ?>)
            </p>
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-2xl overflow-hidden">
            <form action="<?= BASE_URL ?>/index.php?url=book/update/<?= htmlspecialchars($book['id']) ?>" method="post" enctype="multipart/form-data" class="p-8 md:p-12">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <div class="md:col-span-1">
                        <label for="id_display" class="block text-sm font-bold text-slate-500 mb-2 uppercase tracking-wide">ID v databázi</label>
                        <input type="text" id="id_display" value="<?= htmlspecialchars($book['id']) ?>" readonly 
                            class="w-full px-5 py-4 rounded-xl border border-slate-100 bg-slate-50 text-slate-400 font-mono outline-none cursor-not-allowed">
                    </div>

                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Název knihy <span class="text-brand">*</span></label>
                        <input type="text" id="title" name="title" value="<?= htmlspecialchars($book['title']) ?>" required 
                            class="w-full px-5 py-4 rounded-xl border border-slate-200 focus:ring-4 focus:ring-brand-light focus:border-brand transition outline-none text-lg shadow-sm">
                    </div>

                    <div>
                        <label for="author" class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Autor <span class="text-brand">*</span></label>
                        <input type="text" id="author" name="author" value="<?= htmlspecialchars($book['author']) ?>" required 
                            class="w-full px-5 py-4 rounded-xl border border-slate-200 focus:ring-4 focus:ring-brand-light focus:border-brand transition outline-none shadow-sm">
                    </div>

                    <div>
                        <label for="isbn" class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">ISBN <span class="text-brand">*</span></label>
                        <input type="text" id="isbn" name="isbn" value="<?= htmlspecialchars($book['isbn']) ?>" 
                            class="w-full px-5 py-4 rounded-xl border border-slate-200 focus:ring-4 focus:ring-brand-light focus:border-brand transition outline-none font-mono shadow-sm">
                    </div>

                    <div>
                        <label for="category" class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Kategorie</label>
                        <input type="text" id="category" name="category" value="<?= htmlspecialchars($book['category']) ?>" 
                            class="w-full px-5 py-4 rounded-xl border border-slate-200 focus:ring-4 focus:ring-brand-light focus:border-brand transition outline-none shadow-sm">
                    </div>

                    <div>
                        <label for="subcategory" class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Podkategorie</label>
                        <input type="text" id="subcategory" name="subcategory" value="<?= htmlspecialchars($book['subcategory']) ?>" 
                            class="w-full px-5 py-4 rounded-xl border border-slate-200 focus:ring-4 focus:ring-brand-light focus:border-brand transition outline-none shadow-sm">
                    </div>

                    <div>
                        <label for="year" class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Rok vydání <span class="text-brand">*</span></label>
                        <input type="number" id="year" name="year" value="<?= htmlspecialchars($book['year']) ?>" required 
                            class="w-full px-5 py-4 rounded-xl border border-slate-200 focus:ring-4 focus:ring-brand-light focus:border-brand transition outline-none shadow-sm font-mono">
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Cena knihy (Kč)</label>
                        <input type="number" id="price" name="price" step="0.5" value="<?= htmlspecialchars($book['price']) ?>" 
                            class="w-full px-5 py-4 rounded-xl border border-slate-200 focus:ring-4 focus:ring-brand-light focus:border-brand transition outline-none shadow-sm font-mono text-brand font-bold text-xl">
                    </div>

                    <div class="md:col-span-2">
                        <label for="link" class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Odkaz</label>
                        <input type="text" id="link" name="link" value="<?= htmlspecialchars($book['link']) ?>"
                            class="w-full px-5 py-4 rounded-xl border border-slate-200 focus:ring-4 focus:ring-brand-light focus:border-brand transition outline-none shadow-sm">
                    </div>

                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Popis knihy</label>
                        <textarea id="description" name="description" rows="5" 
                            class="w-full px-5 py-4 rounded-xl border border-slate-200 focus:ring-4 focus:ring-brand-light focus:border-brand transition outline-none shadow-sm resize-none"><?= htmlspecialchars($book['description']) ?></textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-slate-700 mb-3 uppercase tracking-wide">
                            Stávající obrázky
                        </label>

                        <?php 
                            $existingImages = json_decode($book['images'], true); 
                            if (!empty($existingImages)): 
                        ?>
                            <div class="mb-6 p-6 bg-slate-50 rounded-2xl border border-slate-100 shadow-inner">
                                <div class="flex flex-wrap gap-4 mb-4">
                                    <?php foreach ($existingImages as $img): ?>
                                        <div class="group relative">
                                            <img src="<?= BASE_URL ?>/public/uploads/<?= htmlspecialchars($img) ?>" 
                                                 class="w-24 h-32 object-cover rounded-lg border-2 border-white shadow-md transition-transform group-hover:scale-105">
                                            <span class="absolute -bottom-2 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-[10px] px-2 py-0.5 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                                                <?= htmlspecialchars($img) ?>
                                            </span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                
                                <div class="bg-amber-50 border border-amber-200 p-4 rounded-xl flex items-start space-x-3">
                                    <span class="text-lg">⚠️</span>
                                    <p class="text-xs text-amber-800 leading-relaxed">
                                        <strong>Upozornění:</strong> Pokud nahrajete nové soubory, tyto stávající budou v databázi <strong>přepsány</strong>. Pokud je chcete zachovat, nevybírejte žádné nové soubory.
                                    </p>
                                </div>
                            </div>
                        <?php else: ?>
                            <p class="text-xs text-slate-400 italic mb-4">Kniha zatím nemá žádné obrázky.</p>
                        <?php endif; ?>

                        <div class="w-full">
                            <label for="images" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-200 border-dashed rounded-2xl cursor-pointer bg-white hover:bg-brand-light hover:border-brand transition-all shadow-sm group">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center">
                                    <span class="text-3xl mb-1 opacity-40 group-hover:opacity-100 transition">📸</span>
                                    <span id="file-title" class="text-sm text-slate-600 font-semibold group-hover:text-brand transition-colors">
                                        Klikni pro nahrání nových souborů
                                    </span>
                                    <span id="file-info" class="text-xs text-slate-400 mt-1 px-4 tracking-tight">
                                        Žádné soubory nebyly vybrány
                                    </span>
                                </div>
                                <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden">
                            </label>
                        </div>
                    </div>

                </div>

                <div class="mt-12 pt-8 border-t border-slate-100 flex flex-col md:flex-row items-center justify-between gap-4">
                    <a href="<?= BASE_URL ?>/index.php" class="text-slate-500 font-bold hover:text-slate-800 transition px-6 py-4 rounded-xl hover:bg-slate-50">
                        Zrušit změny
                    </a>
                    
                    <button type="submit" class="w-full md:w-auto bg-brand text-white px-12 py-4 rounded-xl font-extrabold text-lg hover:bg-brand-dark transition shadow-lg shadow-sky-100 flex items-center justify-center space-x-2 active:scale-95">
                        <span>✅</span>
                        <span>Uložit změny do DB</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</main>

<script>
const fileInput = document.getElementById('images');
const fileTitle = document.getElementById('file-title');
const fileInfo = document.getElementById('file-info');

fileInput.addEventListener('change', function(event) {
    const files = event.target.files;
    
    if (files.length === 0) {
        fileTitle.textContent = 'Klikni pro výběr souborů';
        fileTitle.className = 'text-sm text-slate-600 font-semibold transition-colors';
        fileInfo.textContent = 'Žádné soubory nebyly vybrány';
        fileInfo.className = 'text-xs text-slate-400 mt-1 px-4 tracking-tight';
    } else if (files.length === 1) {
        fileTitle.textContent = 'Soubor připraven ✅';
        fileTitle.className = 'text-sm text-brand font-bold transition-colors';
        fileInfo.textContent = files[0].name;
        fileInfo.className = 'text-xs text-brand-dark mt-1 font-medium';
    } else {
        fileTitle.textContent = 'Soubory připraveny ✅';
        fileTitle.className = 'text-sm text-brand font-bold transition-colors';
        fileInfo.textContent = 'Vybráno celkem: ' + files.length + ' souborů';
        fileInfo.className = 'text-xs text-brand-dark mt-1 font-medium';
    }
});
</script>

<?php require_once '../app/views/layout/footer.php'; ?>
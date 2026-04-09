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
                            <label class="block text-sm font-bold text-slate-700 mb-3 uppercase tracking-wide">Obrázky (možnost změny)</label>
                            <label class="group relative flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-slate-300 rounded-2xl cursor-pointer bg-slate-50 hover:bg-brand-light hover:border-brand transition-all">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <span class="text-2xl mb-1 opacity-50 group-hover:opacity-100 transition">📁</span>
                                    <p class="text-sm text-slate-600 font-semibold group-hover:text-brand">Klikni pro výběr nových souborů</p>
                                </div>
                                <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden">
                            </label>
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
<?php require_once '../app/views/layout/footer.php'; ?>
   